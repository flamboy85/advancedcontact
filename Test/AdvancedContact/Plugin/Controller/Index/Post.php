<?php
namespace Test\AdvancedContact\Plugin\Controller\Index;

use Magento\Contact\Controller\Index\Post as corePost;
use Test\AdvancedContact\Model\ContactFactory;
use Test\AdvancedContact\Model\Contact\Source\StatusOptions;

/**
 * Class Post
 * @package Test\AdvancedContact\Plugin\Controller\Index
 */
class Post
{
    /**
     * Contact Factory
     *
     * @var ContactFactory
     */
    protected $_contactFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;


    /**
     * Post constructor.
     * @param ContactFactory $contactFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        ContactFactory $contactFactory,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->_contactFactory = $contactFactory;
        $this->_logger = $logger;
    }

    /**
     * Plugin after execute action
     * that send post data to admin
     *
     * @param corePost $subject
     * @param $result
     * @return mixed
     */
    public function afterExecute(corePost $subject, $result)
    {
        $post = $subject->getRequest()->getPostValue();
        if (!$post) {

            return $result;
        }
        try {
            $error = false;

            if (!\Zend_Validate::is(trim($post['name']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['comment']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                $error = true;
            }
            if (\Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                $error = true;
            }
            if ($error) {
                throw new \Exception();
            }
            /** @var \Test\AdvancedContact\Model\Contact $contact */
            $contact = $this->_contactFactory->create();
            $contact->setData($post)
                ->setStatus(StatusOptions::STATUS_NOT_NOTIFIED)
                ->save();
        } catch (\Exception $e) {
            $this->_logger->info($e->getMessage());
        }

        return $result;
    }
}