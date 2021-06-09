<?php

namespace Dotdigitalgroup\Email\Setup;

use Dotdigitalgroup\Email\Helper\Config;
use Dotdigitalgroup\Email\Helper\Data;
use Dotdigitalgroup\Email\Helper\Transactional;
use Dotdigitalgroup\Email\Setup\SchemaInterface as Schema;
use Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory;
use Magento\Framework\App\Config\ReinitableConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Config\Model\ResourceModel\Config as ConfigResource;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\User\Model\ResourceModel\User;
use Magento\User\Model\ResourceModel\User\CollectionFactory as UserCollectionFactory;
use Dotdigitalgroup\Email\Model\Sync\DummyRecordsFactory;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * @var CollectionFactory
     */
    private $configCollectionFactory;

    /**
     * @var ReinitableConfigInterface
     */
    private $config;

    /**
     * @var UserCollectionFactory
     */
    private $userCollectionFactory;

    /**
     * @var User
     */
    private $userResource;

    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    /**
     * @var DummyRecordsFactory
     */
    private $dummyRecordsFactory;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var ConfigResource
     */
    private $configResource;

    /**
     * UpgradeData constructor.
     * @param Data $helper
     * @param CollectionFactory $configCollectionFactory
     * @param ReinitableConfigInterface $config
     * @param UserCollectionFactory $userCollectionFactory
     * @param User $userResource
     * @param EncryptorInterface $encryptor
     * @param DummyRecordsFactory $dummyRecordsFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param ConfigResource $configResource
     */
    public function __construct(
        Data $helper,
        CollectionFactory $configCollectionFactory,
        ReinitableConfigInterface $config,
        UserCollectionFactory $userCollectionFactory,
        User $userResource,
        EncryptorInterface $encryptor,
        DummyRecordsFactory $dummyRecordsFactory,
        ScopeConfigInterface $scopeConfig,
        ConfigResource $configResource
    ) {
        $this->configCollectionFactory = $configCollectionFactory;
        $this->helper = $helper;
        $this->config = $config;
        $this->userCollectionFactory = $userCollectionFactory;
        $this->userResource = $userResource;
        $this->encryptor = $encryptor;
        $this->dummyRecordsFactory = $dummyRecordsFactory;
        $this->scopeConfig = $scopeConfig;
        $this->configResource = $configResource;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (version_compare($context->getVersion(), '2.4.4', '<')) {
            //Encrypt api & transactional password for all websites
            $this->encryptAllPasswords();

            //Encrypt refresh token saved against admin users
            $this->encryptAllRefreshTokens();

            //Clear config cache
            $this->config->reinit();
        }

        if (version_compare($context->getVersion(), '2.0.0', '>=')) {
            if (version_compare($context->getVersion(), '2.5.0', '<')) {
                // Save config for allow non subscriber for features; AC and order review trigger campaign
                //For AC
                $this->helper->saveConfigData(
                    \Dotdigitalgroup\Email\Helper\Config::XML_PATH_REVIEW_ALLOW_NON_SUBSCRIBERS,
                    1,
                    ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                    0
                );
                //For order review
                $this->helper->saveConfigData(
                    \Dotdigitalgroup\Email\Helper\Config::XML_PATH_CONNECTOR_CONTENT_ALLOW_NON_SUBSCRIBERS,
                    1,
                    ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                    0
                );
                //Clear config cache
                $this->config->reinit();
            }
            if (version_compare($context->getVersion(), '2.5.1', '<')) {
                // Save config for allow non subscriber contacts to sync
                $this->helper->saveConfigData(
                    \Dotdigitalgroup\Email\Helper\Config::XML_PATH_CONNECTOR_SYNC_ALLOW_NON_SUBSCRIBERS,
                    1,
                    ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                    0
                );
                //Clear config cache
                $this->config->reinit();
            }
        }

        $this->upgradeFourFourZero($setup, $context);
        $this->upgradeFourFiveThree($context);
        $this->upgradeFourElevenZero($setup, $context);

        $installer->endSetup();
    }

    /**
     * Encrypt all tokens
     */
    private function encryptAllRefreshTokens()
    {
        $userCollection = $this->userCollectionFactory->create()
            ->addFieldToFilter('refresh_token', ['notnull' => true]);

        foreach ($userCollection as $user) {
            $this->encryptAndSaveRefreshToken($user);
        }
    }

    /**
     * Encrypt token and save
     *
     * @param \Magento\User\Model\User $user
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    private function encryptAndSaveRefreshToken($user)
    {
        $user->setRefreshToken(
            $this->encryptor->encrypt($user->getRefreshToken())
        );
        $this->userResource->save($user);
    }

    /**
     * Encrypt passwords and save for all websites
     */
    private function encryptAllPasswords()
    {
        $websites = $this->helper->getWebsites(true);
        $paths = [
            Config::XML_PATH_CONNECTOR_API_PASSWORD,
            Transactional::XML_PATH_DDG_TRANSACTIONAL_PASSWORD
        ];
        foreach ($websites as $website) {
            if ($website->getId() > 0) {
                $scope = ScopeInterface::SCOPE_WEBSITES;
            } else {
                $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
            }

            foreach ($paths as $path) {
                $this->encryptAndSavePassword(
                    $path,
                    $scope,
                    $website->getId()
                );
            }
        }
    }

    /**
     * Encrypt already saved passwords
     *
     * @param string $path
     * @param string $scope
     * @param int $id
     */
    private function encryptAndSavePassword($path, $scope, $id)
    {
        $configCollection = $this->configCollectionFactory->create()
            ->addFieldToFilter('scope', $scope)
            ->addFieldToFilter('scope_id', $id)
            ->addFieldToFilter('path', $path)
            ->setPageSize(1);

        if ($configCollection->getSize()) {
            $value = $configCollection->getFirstItem()->getValue();
            if ($value) {
                $this->helper->saveConfigData(
                    $path,
                    $this->encryptor->encrypt($value),
                    $scope,
                    $id
                );
            }
        }
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    private function upgradeFourFourZero(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        if (version_compare($context->getVersion(), '4.4.0', '<')) {

            $select = $setup->getConnection()->select()->from(
                $setup->getTable('core_config_data'),
                ['config_id', 'value']
            )->where(
                'path = ?',
                \Dotdigitalgroup\Email\Helper\Transactional::XML_PATH_DDG_TRANSACTIONAL_HOST
            );
            foreach ($setup->getConnection()->fetchAll($select) as $configRow) {
                preg_match_all('/\d+/', $configRow['value'], $matches);
                $value = $matches[0];
                //Invalid Smtp Host
                if (!count($value) === 1) {
                    continue;
                }
                $row = [
                    'value' => reset($value)
                ];
                $setup->getConnection()->update(
                    $setup->getTable('core_config_data'),
                    $row,
                    ['config_id = ?' => $configRow['config_id']]
                );
            }
        }
    }

    /**
     * @param $context
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function upgradeFourFiveThree($context)
    {
        if (version_compare($context->getVersion(), '4.5.3', '<')) {
            //Send dummy cartInsight Data
            $this->dummyRecordsFactory
                ->create()
                ->sync();
        }
    }

    /**
     * Translate wishlist modified 1 > imported 0
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    private function upgradeFourElevenZero(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        if (version_compare($context->getVersion(), '4.11.0', '<')) {
            $wishlistTable = $setup->getTable(Schema::EMAIL_WISHLIST_TABLE);

            $setup->getConnection()->update(
                $wishlistTable,
                [
                    'wishlist_imported' => 0,
                    'wishlist_modified' => new \Zend_Db_Expr('null')
                ],
                [
                    'wishlist_modified' => 1
                ]
            );
        }
    }
}
