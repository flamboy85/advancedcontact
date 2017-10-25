<?php

namespace Test\AdvancedContact\Model;

use Test\AdvancedContact\Api\Data\ContactInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Class Contact
 * @package Test\AdvancedContact\Model
 */
class Contact extends \Magento\Framework\Model\AbstractModel implements ContactInterface, IdentityInterface
{
    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'test_advancedcontact_contact';

    /**
     * Cache tag
     *
     * @var string
     */
    protected $_cacheTag = 'test_advancedcontact_contact';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'test_advancedcontact_contact';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Test\AdvancedContact\Model\ResourceModel\Contact');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * get entity default values
     *
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::CONTACT_ID);
    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Get telephone
     *
     * @return string|null
     */
    public function getTelephone()
    {
        return $this->getData(self::TELEPHONE);
    }

    /**
     * Get comment
     *
     * @return string|null
     */
    public function getComment()
    {
        return $this->getData(self::COMMENT);
    }

    /**
     * Get status
     *
     * @return int|null
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Get update at
     *
     * @return string|null
     */
    public function getUpdateAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return ContactInterface
     */
    public function setId($id)
    {
        return $this->setData(self::CONTACT_ID, $id);
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ContactInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Set email
     *
     * @param string $email
     * @return ContactInterface
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return ContactInterface
     */
    public function setTelephone($telephone)
    {
        return $this->setData(self::TELEPHONE, $telephone);
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return ContactInterface
     */
    public function setComment($comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }

    /**
     * Set status
     *
     * @param int $status
     * @return ContactInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return ContactInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return ContactInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
