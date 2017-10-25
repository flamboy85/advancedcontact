<?php

namespace Test\AdvancedContact\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Contact CRUD interface.
 * @api
 */
interface ContactRepositoryInterface
{
    /**
     * Save contact.
     *
     * @param \Test\AdvancedContact\Api\Data\ContactInterface $contact
     * @return \Test\AdvancedContact\Api\Data\ContactInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Test\AdvancedContact\Api\Data\ContactInterface $contact);

    /**
     * Retrieve contact.
     *
     * @param int $contactId
     * @return \Test\AdvancedContact\Api\Data\ContactInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($contactId);

    /**
     * Retrieve contacts matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Test\AdvancedContact\Api\Data\ContactSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete contact.
     *
     * @param \Test\AdvancedContact\Api\Data\ContactInterface $contact
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Test\AdvancedContact\Api\Data\ContactInterface $contact);

    /**
     * Delete contact by ID.
     *
     * @param int $contactId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($contactId);
}
