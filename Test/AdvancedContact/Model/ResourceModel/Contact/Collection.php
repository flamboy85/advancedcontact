<?php

namespace Test\AdvancedContact\Model\ResourceModel\Contact;

/**
 * Class Collection
 * @package Test\AdvancedContact\Model\ResourceModel\Contact
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * ID Field Name
     * 
     * @var string
     */
    protected $_idFieldName = 'contact_id';

    /**
     * Event prefix
     * 
     * @var string
     */
    protected $_eventPrefix = 'test_advancedcontact_contact_collection';

    /**
     * Event object
     * 
     * @var string
     */
    protected $_eventObject = 'contact_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Test\AdvancedContact\Model\Contact', 'Test\AdvancedContact\Model\ResourceModel\Contact');
    }

    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     *
     * @return \Magento\Framework\DB\Select
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(\Zend_Db_Select::GROUP);
        return $countSelect;
    }
    /**
     * @param string $valueField
     * @param string $labelField
     * @param array $additional
     * @return array
     */
    protected function _toOptionArray($valueField = 'contact_id', $labelField = 'name', $additional = [])
    {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }
}
