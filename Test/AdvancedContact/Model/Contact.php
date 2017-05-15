<?php

namespace Test\AdvancedContact\Model;

/**
 * Class Contact
 * @package Test\AdvancedContact\Model
 */
class Contact extends \Magento\Framework\Model\AbstractModel
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
}
