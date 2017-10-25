<?php
namespace Test\AdvancedContact\Controller\Adminhtml\Contact;

class Index extends \Test\AdvancedContact\Controller\Adminhtml\Contact
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Test\AdvancedContact\Api\ContactRepositoryInterface $contactRepository
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Test\AdvancedContact\Api\ContactRepositoryInterface $contactRepository,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $contactRepository, $coreRegistry);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(__('Contacts'));

        $dataPersistor = $this->_objectManager->get('Magento\Framework\App\Request\DataPersistorInterface');
        $dataPersistor->clear('advanced_contact');

        return $resultPage;
    }
}
