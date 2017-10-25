<?php

namespace Test\AdvancedContact\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface ContactSearchResultsInterface
 * @package Test\AdvancedContact\Api\Data
 * @api
 */
interface ContactSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get contact list.
     *
     * @return \Test\AdvancedContact\Api\Data\ContactInterface[]
     */
    public function getItems();

    /**
     * Set contact list.
     *
     * @param \Test\AdvancedContact\Api\Data\ContactInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
