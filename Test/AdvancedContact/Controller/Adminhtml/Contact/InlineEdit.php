<?php

namespace Test\AdvancedContact\Controller\Adminhtml\Contact;

/**
 * Class InlineEdit
 * @package Test\AdvancedContact\Controller\Adminhtml\Contact
 */
class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * JSON Factory
     *
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_jsonFactory;

    /**
     * Contact Factory
     *
     * @var \Test\AdvancedContact\Model\ContactFactory
     */
    protected $_contactFactory;

    /**
     * constructor
     *
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Test\AdvancedContact\Model\ContactFactory $contactFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Test\AdvancedContact\Model\ContactFactory $contactFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_jsonFactory = $jsonFactory;
        $this->_contactFactory = $contactFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->_jsonFactory->create();
        $error = false;
        $messages = [];
        $contactItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($contactItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        foreach (array_keys($contactItems) as $contactId) {
            /** @var \Test\AdvancedContact\Model\Contact $contact */
            $contact = $this->_contactFactory->getById($contactId);
            try {
                $contactData = $contactItems[$contactId];//todo: handle dates
                $contact->addData($contactData);
                $contact->save();
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithContactId($contact, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithContactId($contact, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithContactId(
                    $contact,
                    __('Something went wrong while saving the contact information.')
                );
                $error = true;
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Contact id to error message
     *
     * @param \Test\AdvancedContact\Model\Contact $contact
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithContactId(\Test\AdvancedContact\Model\Contact $contact, $errorText)
    {
        return '[Contact Id: ' . $contact->getId() . '] ' . $errorText;
    }
}
