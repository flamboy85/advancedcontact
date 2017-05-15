<?php
namespace Test\AdvancedContact\Controller\Adminhtml\Contact;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Test\AdvancedContact\Model\Contact\Source\StatusOptions;

/**
 * Class Save
 * @package Test\AdvancedContact\Controller\Adminhtml\Contact
 */
class Save extends \Test\AdvancedContact\Controller\Adminhtml\Contact
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('contact_id');

            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = StatusOptions::STATUS_NOTIFIED;
            }
            if (empty($data['contact_id'])) {
                $data['contact_id'] = null;
            }

            /** @var \Test\AdvancedContact\Model\Contact $model */
            $model = $this->_objectManager->create('Test\AdvancedContact\Model\Contact')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This contact no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the contact.'));
                $this->dataPersistor->clear('advanced_contact');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['contact_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the contact.'));
            }

            $this->dataPersistor->set('advanced_contact', $data);
            return $resultRedirect->setPath('*/*/edit', ['contact_id' => $this->getRequest()->getParam('contact_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
