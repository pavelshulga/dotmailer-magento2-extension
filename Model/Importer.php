<?php

namespace Dotdigitalgroup\Email\Model;


class Importer extends \Magento\Framework\Model\AbstractModel
{

    //import statuses
    const NOT_IMPORTED = 0;
    const IMPORTING = 1;
    const IMPORTED = 2;
    const FAILED = 3;

    //import mode
    const MODE_BULK = 'Bulk';
    const MODE_SINGLE = 'Single';
    const MODE_SINGLE_DELETE = 'Single_Delete';
    const MODE_CONTACT_DELETE = 'Contact_Delete';
    const MODE_SUBSCRIBER_UPDATE = 'Subscriber_Update';
    const MODE_CONTACT_EMAIL_UPDATE = 'Contact_Email_Update';
    const MODE_SUBSCRIBER_RESUBSCRIBED = 'Subscriber_Resubscribed';

    //import type
    const IMPORT_TYPE_GUEST = 'Guest';
    const IMPORT_TYPE_ORDERS = 'Orders';
    const IMPORT_TYPE_CONTACT = 'Contact';
    const IMPORT_TYPE_REVIEWS = 'Reviews';
    const IMPORT_TYPE_WISHLIST = 'Wishlist';
    const IMPORT_TYPE_CONTACT_UPDATE = 'Contact';
    const IMPORT_TYPE_SUBSCRIBERS = 'Subscriber';
    const IMPORT_TYPE_SUBSCRIBER_UPDATE = 'Subscriber';
    const IMPORT_TYPE_SUBSCRIBER_RESUBSCRIBED = 'Subscriber';

    //sync limits
    const SYNC_SINGLE_LIMIT_NUMBER = 100;

    protected $_helper;
    protected $_reasons
        = array(
            'Globally Suppressed',
            'Blocked',
            'Unsubscribed',
            'Hard Bounced',
            'Isp Complaints',
            'Domain Suppressed',
            'Failures',
            'Invalid Entries',
            'Mail Blocked',
            'Suppressed by you'
        );

    protected $import_statuses
        = array(
            'RejectedByWatchdog', 'InvalidFileFormat', 'Unknown',
            'Failed', 'ExceedsAllowedContactLimit', 'NotAvailableInThisVersion'
        );

    protected $_bulkPriority;
    protected $_singlePriority;
    protected $_totalItems;
    protected $_bulkSyncLimit;
    protected $_dateTime;
    protected $_file;
    protected $_contact;
    protected $_objectManager;
    protected $_directoryList;


    /**
     * @param \Magento\Framework\Model\Context                        $context
     * @param \Magento\Framework\Registry                             $registry
     * @param \Magento\Framework\Stdlib\DateTime                      $dateTime
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb           $resourceCollection
     * @param array                                                   $data
     */
    public function __construct(
        \Dotdigitalgroup\Email\Helper\Data $helper,
        \Dotdigitalgroup\Email\Model\Resource\Contact $contact,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Filesystem\Io\File $file,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_file          = $file;
        $this->_helper        = $helper;
        $this->_directoryList = $directoryList;
        $this->_objectManager = $objectManager;
        $this->_contact       = $contact;
        $this->_dateTime      = $dateTime;
        parent::__construct(
            $context, $registry, $resource, $resourceCollection, $data
        );
    }

    /**
     * constructor
     */
    public function _construct()
    {
        $this->_init('Dotdigitalgroup\Email\Model\Resource\Importer');
    }

    public function beforeSave()
    {
        parent::beforeSave();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($this->_dateTime->formatDate(true));
        }
        $this->setUpdatedAt($this->_dateTime->formatDate(true));

        return $this;
    }

    /**
     * register import in queue
     *
     * @param      $importType
     * @param      $importData
     * @param      $importMode
     * @param      $websiteId
     * @param bool $file
     *
     * @return bool
     */
    public function registerQueue($importType, $importData, $importMode,
        $websiteId, $file = false
    ) {
        try {
            if ( ! empty($importData)) {
                $importData = serialize($importData);
            }

            if ($file) {
                $this->setImportFile($file);
            }

            $this->setImportType($importType)
                ->setImportData($importData)
                ->setWebsiteId($websiteId)
                ->setImportMode($importMode)
                ->save();

            return true;
        } catch (\Exception $e) {
            $this->_helper->debug((string)$e, array());
        }

        return false;
    }

    public function processQueue()
    {
        //Set items to 0
        $this->_totalItems = 0;

        //Set bulk sync limit
        $this->_bulkSyncLimit = 5;

        //Set priority
        $this->_setPriority();

        //Check previous import status
        $this->_checkImportStatus();

        //Bulk priority. Process group 1 first
        foreach ($this->_bulkPriority as $bulk) {
            if ($this->_totalItems < $bulk['limit']) {
                $collection = $this->_getQueue(
                    $bulk['type'],
                    $bulk['mode'],
                    $bulk['limit'] - $this->_totalItems
                );
                if ($collection->getSize()) {
                    $this->_totalItems += $collection->getSize();
                    $bulkModel = $this->_objectManager->create($bulk['model']);
                    $bulkModel->sync($collection);
                }
            }
        }

        //reset total items to 0
        $this->_totalItems = 0;

        //Single/Update priority.
        foreach ($this->_singlePriority as $single) {
            if ($this->_totalItems < $single['limit']) {
                $collection = $this->_getQueue(
                    $single['type'],
                    $single['mode'],
                    $single['limit'] - $this->_totalItems
                );
                if ($collection->getSize()) {
                    $this->_totalItems += $collection->getSize();
                    $singleModel = $this->_objectManager->create(
                        $single['model']
                    );
                    $singleModel->sync($collection);
                }
            }
        }
    }

    protected function _setPriority()
    {
        /**
         * Bulk
         */

        $defaultBulk = array(
            'model' => '',
            'mode'  => self::MODE_BULK,
            'type' => '',
            'limit' => $this->_bulkSyncLimit
        );

        //Contact Bulk
        $contact = $defaultBulk;
        $contact['model'] = 'Dotdigitalgroup\Email\Model\Sync\Contact\Bulk';
        $contact['type'] = array(
            self::IMPORT_TYPE_CONTACT,
            self::IMPORT_TYPE_GUEST,
            self::IMPORT_TYPE_SUBSCRIBERS
        );

        //Bulk Order
        $order = $defaultBulk;
        $order['model'] = 'Dotdigitalgroup\Email\Model\Sync\Td\Bulk';
        $order['type'] = self::IMPORT_TYPE_ORDERS;

        //Bulk Other TD
        $other = $defaultBulk;
        $other['model'] = 'Dotdigitalgroup\Email\Model\Sync\Td\Bulk';
        $other['type'] = array(
            'Catalog',
            self::IMPORT_TYPE_REVIEWS,
            self::IMPORT_TYPE_WISHLIST
        );

        /**
         * Update
         */

        $defaultSingleUpdate = array(
            'model' => 'Dotdigitalgroup\Email\Model\Sync\Contact\Update',
            'mode' => '',
            'type' => '',
            'limit' => self::SYNC_SINGLE_LIMIT_NUMBER
        );

        //Subscriber resubscribe
        $subscriberResubscribe = $defaultSingleUpdate;
        $subscriberResubscribe['mode'] = self::MODE_SUBSCRIBER_RESUBSCRIBED;
        $subscriberResubscribe['type'] = self::IMPORT_TYPE_SUBSCRIBER_RESUBSCRIBED;

        //Subscriber update/suppressed
        $subscriberUpdate = $defaultSingleUpdate;
        $subscriberUpdate['mode'] = self::MODE_SUBSCRIBER_UPDATE;
        $subscriberUpdate['type'] = self::IMPORT_TYPE_SUBSCRIBER_UPDATE;

        //Email Change
        $emailChange = $defaultSingleUpdate;
        $emailChange['mode'] = self::MODE_CONTACT_EMAIL_UPDATE;
        $emailChange['type'] = self::IMPORT_TYPE_CONTACT_UPDATE;

        //Order Update
        $orderUpdate = $defaultSingleUpdate;
        $orderUpdate['model'] = 'Dotdigitalgroup\Email\Model\Sync\Td\Update';
        $orderUpdate['mode'] = self::MODE_SINGLE;
        $orderUpdate['type'] = self::IMPORT_TYPE_ORDERS;

        //Update Other TD
        $updateOtherTd = $defaultSingleUpdate;
        $updateOtherTd['model'] = 'Dotdigitalgroup\Email\Model\Sync\Td\Update';
        $updateOtherTd['mode'] = self::MODE_SINGLE;
        $updateOtherTd['type'] = array(
            'Catalog',
            self::IMPORT_TYPE_WISHLIST
        );

        /**
         * Delete
         */

        $defaultSingleDelete = array(
            'model' => '',
            'mode' => '',
            'type' => '',
            'limit' => self::SYNC_SINGLE_LIMIT_NUMBER
        );

        //Contact Delete
        $contactDelete = $defaultSingleDelete;
        $contactDelete['model'] = 'Dotdigitalgroup\Email\Model\Sync\Contact\Delete';
        $contactDelete['mode'] = self::MODE_CONTACT_DELETE;
        $contactDelete['type'] = self::IMPORT_TYPE_CONTACT;

        //TD Delete
        $tdDelete = $defaultSingleDelete;
        $tdDelete['model'] = 'Dotdigitalgroup\Email\Model\Sync\Td\Delete';
        $tdDelete['mode']  = self::MODE_SINGLE_DELETE;
        $tdDelete['type']  = array(
            'Catalog',
            self::IMPORT_TYPE_REVIEWS,
            self::IMPORT_TYPE_WISHLIST,
            self::IMPORT_TYPE_ORDERS
        );


        //Bulk Priority
        $this->_bulkPriority = array(
            $contact,
            $order,
            $other
        );

        $this->_singlePriority = array(
            $subscriberResubscribe,
            $subscriberUpdate,
            $emailChange,
            $orderUpdate,
            $updateOtherTd,
            $contactDelete,
            $tdDelete
        );

    }

    protected function _checkImportStatus()
    {

        $this->_helper->allowResourceFullExecution();
        if ($items = $this->_getImportingItems($this->_bulkSyncLimit)) {
            foreach ($items as $item) {
                $websiteId = $item->getWebsiteId();
                $client    = $this->_helper->getWebsiteApiClient(
                    $websiteId
                );
                if ($client) {
                    try {
                        if (
                            $item->getImportType() == self::IMPORT_TYPE_CONTACT
                            or
                            $item->getImportType()
                            == self::IMPORT_TYPE_SUBSCRIBERS
                            or
                            $item->getImportType() == self::IMPORT_TYPE_GUEST

                        ) {
                            $response = $client->getContactsImportByImportId(
                                $item->getImportId()
                            );
                        } else {
                            $response
                                = $client->getContactsTransactionalDataImportByImportId(
                                $item->getImportId()
                            );
                        }
                    } catch (\Exception $e) {
                        $item->setMessage($e->getMessage())
                            ->setImportStatus(self::FAILED)
                            ->save();
                        continue;
                    }

                    if ($response) {
                        if ($response->status == 'Finished') {
                            $now = gmdate('Y-m-d H:i:s');

                            $item->setImportStatus(self::IMPORTED)
                                ->setImportFinished($now)
                                ->setMessage('')
                                ->save();
                            if (
                                $item->getImportType()
                                == self::IMPORT_TYPE_CONTACT or
                                $item->getImportType()
                                == self::IMPORT_TYPE_SUBSCRIBERS or
                                $item->getImportType()
                                == self::IMPORT_TYPE_GUEST

                            ) {
                                if ($item->getImportId()) {
                                    $this->_processContactImportReportFaults(
                                        $item->getImportId(), $websiteId
                                    );
                                }
                            }
                        } elseif (in_array(
                            $response->status, $this->import_statuses
                        )) {
                            $item->setImportStatus(self::FAILED)
                                ->setMessage(
                                    'Import failed with status '
                                    . $response->status
                                )
                                ->save();
                        } else {
                            //Not finished
                            $this->_totalItems += 1;
                        }
                    }
                }
            }
        }
    }

    protected function _getImportingItems($limit)
    {
        $collection = $this->getCollection()
            ->addFieldToFilter('import_status', array('eq' => self::IMPORTING))
            ->addFieldToFilter('import_id', array('neq' => ''))
            ->setPageSize($limit)
            ->setCurPage(1);

        if ($collection->getSize()) {
            return $collection;
        }

        return false;
    }

    protected function _processContactImportReportFaults($id, $websiteId)
    {
        $client   = $this->_helper->getWebsiteApiClient($websiteId);
        $response = $client->getContactImportReportFaults($id);

        if ($response) {
            $data = $this->_removeUtf8Bom($response);
            $fileName = $this->_directoryList->getPath('var')
                . DIRECTORY_SEPARATOR . 'DmTempCsvFromApi.csv';
            $this->_file->open();
            $check = $this->_file->write($fileName, $data);

            if ($check) {
                $csvArray = $this->_csvToArray($fileName);
                $this->_file->rm($fileName);
                $this->_contact->unsubscribe($csvArray);
            } else {
                $this->_helper->log(
                    '_processContactImportReportFaults: cannot save data to CSV file.'
                );
            }
        }
    }

    protected function _removeUtf8Bom($text)
    {
        $bom  = pack('H*', 'EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);

        return $text;
    }

    protected function _csvToArray($filename)
    {
        if ( ! file_exists($filename) || ! is_readable($filename)) {
            return false;
        }

        $header = null;
        $data   = array();
        if (($handle = fopen($filename, 'r')) !== false) {

            while (($row = fgetcsv($handle)) !== false) {

                if ( ! $header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        $contacts = array();
        foreach ($data as $item) {
            if (in_array($item['Reason'], $this->_reasons)) {
                $contacts[] = $item['email'];
            }
        }

        return $contacts;
    }

    protected function _getQueue($importType, $importMode, $limit)
    {
        $collection = $this->getCollection();

        if (is_array($importType)) {
            $condition = array();
            foreach ($importType as $type) {
                if ($type == 'Catalog') {
                    $condition[] = array('like' => $type . '%');
                } else {
                    $condition[] = array('eq' => $type);
                }
            }
            $collection->addFieldToFilter('import_type', $condition);
        } else {
            $collection->addFieldToFilter(
                'import_type', array('eq' => $importType)
            );
        }

        $collection->addFieldToFilter('import_mode', array('eq' => $importMode))
            ->addFieldToFilter(
                'import_status', array('eq' => self::NOT_IMPORTED)
            )
            ->setPageSize($limit)
            ->setCurPage(1);

        return $collection;
    }
}