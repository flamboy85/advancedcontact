<?php

namespace Test\AdvancedContact\Model;

use Test\AdvancedContact\Api\Data;
use Test\AdvancedContact\Api\ContactRepositoryInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Test\AdvancedContact\Model\ResourceModel\Contact as ResourceBlock;
use Test\AdvancedContact\Model\ResourceModel\Contact\CollectionFactory as ContactCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ContactRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ContactRepository implements ContactRepositoryInterface
{
    /**
     * @var ResourceBlock
     */
    protected $resource;

    /**
     * @var ContactFactory
     */
    protected $contactFactory;

    /**
     * @var ContactCollectionFactory
     */
    protected $contactCollectionFactory;

    /**
     * @var Data\ContactSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $criteriaBuilder;

    /**
     * ContactRepository constructor.
     * @param ResourceBlock $resource
     * @param ContactFactory $contactFactory
     * @param ContactCollectionFactory $contactCollectionFactory
     * @param Data\ContactSearchResultsInterfaceFactory $searchResultsFactory
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $criteriaBuilder
     */
    public function __construct(
        ResourceBlock $resource,
        ContactFactory $contactFactory,
        ContactCollectionFactory $contactCollectionFactory,
        Data\ContactSearchResultsInterfaceFactory $searchResultsFactory,
        StoreManagerInterface $storeManager,
        \Magento\Framework\Api\SearchCriteriaBuilder $criteriaBuilder
    ) {
        $this->resource = $resource;
        $this->contactFactory = $contactFactory;
        $this->contactCollectionFactory = $contactCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->storeManager = $storeManager;
        $this->criteriaBuilder = $criteriaBuilder;
    }

    /**
     * Save contact data
     *
     * @param Data\ContactInterface $contact
     * @return Data\ContactInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\ContactInterface $contact)
    {
        try {
            $this->resource->save($contact);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $contact;
    }

    /**
     * Load contact data by given contact Identity
     *
     * @param string $contactId
     * @return Contact
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($contactId)
    {
        $contact = $this->contactFactory->create();
        $this->resource->load($contact, $contactId);
        if (!$contact->getId()) {
            throw new NoSuchEntityException(__('Contact with id "%1" does not exist.', $contactId));
        }

        return $contact;
    }

    /**
     * Load contact data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Test\AdvancedContact\Model\ResourceModel\Contact\Collection
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->contactCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * Delete contact
     *
     * @param Data\ContactInterface $contact
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\ContactInterface $contact)
    {
        try {
            $this->resource->delete($contact);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete contact by given contact Identity
     *
     * @param string $contactId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($contactId)
    {
        return $this->delete($this->getById($contactId));
    }
}
