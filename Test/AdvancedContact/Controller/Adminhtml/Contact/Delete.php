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
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('contact_id');
        if ($id) {
            try {
                $this->contactRepository->deleteById($id);
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the contact.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['contact_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a contact to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
