<?php
namespace Test\AdvancedContact\Controller\Adminhtml\Contact;

use Test\AdvancedContact\Model\ContactFactory;
use Test\AdvancedContact\Model\Contact\Source\StatusOptions;
/**
 * Class SendFeedback
 * @package Test\AdvancedContact\Controller\Adminhtml\Contact
 */
class SendFeedback extends \Test\AdvancedContact\Controller\Adminhtml\Contact
{
    /**
     * Email feedback template
     */
    const XML_PATH_EMAIL_TEMPLATE = 'advanced_contact/feedback_email_template';

    /**
     * Sender email
     */
    const XML_PATH_EMAIL_SENDER = 'advanced_contact/feedback_sender_email_identity';
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Test\AdvancedContact\Helper\Data
     */
    protected $helper;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;
    /**
     * Contact Factory
     *
     * @var ContactFactory
     */
    protected $_contactFactory;


    /**
     * SendFeedback constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Test\AdvancedContact\Helper\Data $helper
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param ContactFactory $_contactFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Test\AdvancedContact\Helper\Data $helper,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        ContactFactory $_contactFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->helper = $helper;
        $this->_transportBuilder = $transportBuilder;
        $this->_contactFactory = $_contactFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $response = [];
            $post = $this->getRequest()->getPostValue();
            if (!$post) {
                throw new \Exception();
            }

            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($post);

            $error = false;

            if (!\Zend_Validate::is(trim($post['subject']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['content']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                $error = true;
            }
            if ($error) {
                throw new \Exception();
            }

            $transport = $this->_transportBuilder
                ->setTemplateIdentifier($this->helper->getGeneralConfig(self::XML_PATH_EMAIL_TEMPLATE))
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($this->helper->getGeneralConfig(self::XML_PATH_EMAIL_SENDER))
                ->addTo($post['email'])
                ->getTransport();

            $transport->sendMessage();
            $this->saveContact();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $response = ['error' => true, 'message' => $e->getMessage()];
        } catch (\Exception $e) {
            $response = ['error' => true, 'message' => __('Cannot send feedback.')];
        }
        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData($response);
        return $resultJson;
    }


    /**
     * Save contact status
     *
     * @return $this
     */
    protected function saveContact()
    {
        $id = $this->getRequest()->getParam('contact_id');
        $contact = $this->_contactFactory->create();
        if ($id) {
            $contact->load($id);
            if (!$contact->getId()) {
                $this->messageManager->addErrorMessage(__('This contact no longer exists.'));
            }
            else {
                $contact->setStatus(StatusOptions::STATUS_NOTIFIED)->save();
                $this->messageManager->addSuccessMessage(__('Contact saved'));
            }
        }

        return $this;
    }
}
