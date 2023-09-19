<?php

namespace Dotdigitalgroup\Email\Controller\Adminhtml\Datafield;

use Dotdigitalgroup\Email\Model\Apiconnector\DataField;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface as MessageManager;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Dotdigitalgroup_Email::automation';

    /**
     * @var MessageManager
     */
    protected $messageManager;

    /**
     * @var DataField
     */
    private $datafieldHandler;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * Save constructor.
     *
     * @param DataField $datafieldHandler
     * @param Context $context
     */
    public function __construct(
        DataField $datafieldHandler,
        Context $context
    ) {
        $this->datafieldHandler = $datafieldHandler;
        $this->messageManager = $context->getMessageManager();
        $this->request = $context->getRequest();

        parent::__construct($context);
    }

    /**
     * Execute method.
     *
     * @return null|void
     */
    public function execute()
    {
        $datafield  = $this->request->getParam('name');

        if (!empty($datafield)) {
            if (!$this->datafieldHandler->hasValidLength($datafield)) {
                $this->messageManager->addErrorMessage(__('Please limit Data Field Name to 20 characters.'));
                return;
            }
            $response = $this->datafieldHandler->createDatafield(
                (int) $this->request->getParam('website_id'),
                $datafield,
                $this->request->getParam('type'),
                $this->request->getParam('visibility'),
                $this->request->getParam('default')
            );

            if (isset($response->message)) {
                $this->messageManager->addErrorMessage($response->message);
            } else {
                $this->messageManager->addSuccessMessage(__('Data field successfully created.'));
            }
        }
    }
}
