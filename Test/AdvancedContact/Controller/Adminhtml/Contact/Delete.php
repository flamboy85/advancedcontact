<?php
namespace Test\AdvancedContact\Controller\Adminhtml\Contact;

/**
 * Class Delete
 * @package Test\AdvancedContact\Controller\Adminhtml\Contact
 */
class Delete extends \Test\AdvancedContact\Controller\Adminhtml\Contact
{
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('contact_id');
        if ($id) {
            try {
                $model = $this->_objectManager->create('Test\AdvancedContact\Model\Contact');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the contact.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['contact_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a contact to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
