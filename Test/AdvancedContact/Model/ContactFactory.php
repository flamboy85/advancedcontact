<?php
namespace Test\AdvancedContact\Model;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class ContactFactory
 * @package Test\AdvancedContact\Model
 */
class ContactFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Test\\AdvancedContact\\Model\\Contact')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Test\AdvancedContact\Model\Contact
     */
    public function create(array $data = array())
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }

    /**
     * Get Contact Object
     *
     * @param $contactId
     * @return \Test\AdvancedContact\Model\Contact
     * @throws NoSuchEntityException
     */
    public function getById($contactId)
    {
        $contact = $this->create();
        $contact->load($contactId);
        if (!$contact->getId()) {
            throw new NoSuchEntityException(__('Contact with id "%1" does not exist.', $contactId));
        }
        return $contact;
    }
}