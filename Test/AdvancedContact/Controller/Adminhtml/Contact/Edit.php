<?php
namespace Test\AdvancedContact\Controller\Adminhtml\Contact;

/**
 * Class Edit
 * @package Test\AdvancedContact\Controller\Adminhtml\Contact
 */
class Edit extends \Test\AdvancedContact\Controller\Adminhtml\Contact
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Edit constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Test\AdvancedContact\Api\ContactRepositoryInterface $contactRepository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Test\AdvancedContact\Api\ContactRepositoryInterface $contactRepository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $contactRepository, $coreRegistry);
    }

    /**
     * Edit Contact
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('contact_id');
        if ($id) {
            $model = $this->contactRepository->getById($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This contact no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
            $this->_coreRegistry->register('test_advancedcontact_contact', $model);
        }
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Contact') : __('New Contact'),
            $id ? __('Edit Contact') : __('New Contact')
        );
        $title = $id ? __('Edit Contact #').$id : __('New Contact');
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
