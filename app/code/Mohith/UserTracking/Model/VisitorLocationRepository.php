<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 2/4/22
 * Time: 1:04 PM
 */

namespace Mohith\UserTracking\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Model\AbstractModel;
use Mohith\UserTracking\Api\Data\VisitorLocationInterface;
use Mohith\UserTracking\Api\Data\VisitorLocationInterfaceFactory;
use Mohith\UserTracking\Api\Data\VisitorLocationSearchResultInterface;
use Mohith\UserTracking\Api\Data\VisitorLocationSearchResultInterfaceFactory;
use Mohith\UserTracking\Api\VisitorLocationRepositoryInterface;
use Mohith\UserTracking\Model\ResourceModel\VisitorLocation as VisitorLocationResourceModel;
use Mohith\UserTracking\Model\ResourceModel\VisitorLocation\Collection;
use Mohith\UserTracking\Model\ResourceModel\VisitorLocation\CollectionFactory as VisitorLocationCollectionFactory;
use Psr\Log\LoggerInterface;

/**
 * Class VisitorLocationRepository
 * @package Mohith\UserTracking\Model
 */
class VisitorLocationRepository implements VisitorLocationRepositoryInterface
{
    /**
     * Cached instances
     *
     * @var array
     */
    protected $instances = [];

    /**
     * VisitorLocation resource model
     *
     * @var VisitorLocationResourceModel
     */
    protected $resource;

    /**
     * VisitorLocation collection factory
     *
     * @var VisitorLocationCollectionFactory
     */
    protected $VisitorLocationCollectionFactory;

    /**
     * VisitorLocation interface factory
     *
     * @var VisitorLocationInterfaceFactory
     */
    protected $VisitorLocationInterfaceFactory;

    /**
     * Data Object Helper
     *
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Search result factory
     *
     * @var VisitorLocationSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * VisitorLocationRepository constructor.
     *
     * @param VisitorLocationResourceModel $resource
     * @param VisitorLocationCollectionFactory $VisitorLocationCollectionFactory
     * @param VisitorLocationInterfaceFactory $VisitorLocationInterfaceFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param VisitorLocationSearchResultInterfaceFactory $searchResultsFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        VisitorLocationResourceModel $resource,
        VisitorLocationCollectionFactory $VisitorLocationCollectionFactory,
        VisitorLocationInterfaceFactory $VisitorLocationInterfaceFactory,
        DataObjectHelper $dataObjectHelper,
        VisitorLocationSearchResultInterfaceFactory $searchResultsFactory,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->VisitorLocationCollectionFactory = $VisitorLocationCollectionFactory;
        $this->VisitorLocationInterfaceFactory = $VisitorLocationInterfaceFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->logger = $logger;
    }

    /**
     * Save VisitorLocation.
     *
     * @param VisitorLocationInterface $VisitorLocation
     * @return AbstractModel|VisitorLocationInterface
     */
    public function save(VisitorLocationInterface $VisitorLocation)
    {
        try {

            /** @var VisitorLocationInterface|AbstractModel $VisitorLocation */
            try {
                $this->resource->save($VisitorLocation);
            } catch (\Exception $exception) {
                throw new CouldNotSaveException(__(
                    'Could not save the VisitorLocation: %1',
                    $exception->getMessage()
                ));
            }
            return $VisitorLocation;
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Retrieve VisitorLocation.
     *
     * @param int $entityId
     * @return VisitorLocationInterface
     */
    public function getById($entityId)
    {
        try {
            if (!isset($this->instances[$entityId])) {
                /** @var VisitorLocationInterface|AbstractModel $VisitorLocation */
                $VisitorLocation = $this->VisitorLocationInterfaceFactory->create();
                $this->resource->load($VisitorLocation, $entityId);
                if (!$VisitorLocation->getId()) {
                    throw new NoSuchEntityException(__('Requested VisitorLocation doesn\'t exist'));
                }
                $this->instances[$entityId] = $VisitorLocation;
            }
            return $this->instances[$entityId];
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Retrieve VisitorLocation matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return VisitorLocationSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        try {
            try {

                /** @var VisitorLocationSearchResultInterface $searchResults */
                $searchResults = $this->searchResultsFactory->create();
                $searchResults->setSearchCriteria($searchCriteria);

                /** @var Collection $collection */
                $collection = $this->VisitorLocationCollectionFactory->create();

                //Add filters from root filter group to the collection
                /** @var FilterGroup $group */
                foreach ($searchCriteria->getFilterGroups() as $group) {
                    $this->addFilterGroupToCollection($group, $collection);
                }
                $sortOrders = $searchCriteria->getSortOrders();
                /** @var SortOrder $sortOrder */
                if ($sortOrders) {
                    foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                        $field = $sortOrder->getField();
                        $collection->addOrder(
                            $field,
                            ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                        );
                    }
                } else {
                    // set a default sorting order since this method is used constantly in many
                    // different blocks
                    $field = '$entity_id';
                    $collection->addOrder($field, 'ASC');
                }
                $collection->setCurPage($searchCriteria->getCurrentPage());
                $collection->setPageSize($searchCriteria->getPageSize());

                /** @var VisitorLocationInterface[] $team */
                $team = [];
                /** @var VisitorLocation $VisitorLocation */
                foreach ($collection as $VisitorLocation) {
                    /** @var VisitorLocationInterface $VisitorLocationDataObject */
                    $VisitorLocationDataObject = $this->VisitorLocationInterfaceFactory->create();
                    $this->dataObjectHelper->populateWithArray(
                        $VisitorLocationDataObject,
                        $VisitorLocation->getData(),
                        VisitorLocationInterface::class
                    );
                    $team[] = $VisitorLocationDataObject;
                }
                $searchResults->setTotalCount($collection->getSize());
                return $searchResults->setItems($team);
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Delete VisitorLocation.
     *
     * @param VisitorLocationInterface $VisitorLocation
     * @return bool true on success
     */
    public function delete(VisitorLocationInterface $VisitorLocation)
    {
        try {

            /** @var VisitorLocationInterface|AbstractModel $VisitorLocation */
            $id = $VisitorLocation->getId();
            try {
                unset($this->instances[$id]);
                $this->resource->delete($VisitorLocation);
            } catch (ValidatorException $e) {
                throw new CouldNotSaveException(__($e->getMessage()));
            } catch (\Exception $e) {
                throw new StateException(
                    __('Unable to remove VisitorLocation %1', $id)
                );
            }
            unset($this->instances[$id]);
            return true;
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Delete VisitorLocation by ID.
     *
     * @param int $entityId
     * @return bool true on success
     */
    public function deleteById($entityId)
    {
        try {
            $VisitorLocation = $this->getById($entityId);
            return $this->delete($VisitorLocation);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param FilterGroup $filterGroup
     * @param Collection $collection
     * @return $this
     */
    protected function addFilterGroupToCollection(
        FilterGroup $filterGroup,
        Collection $collection
    ) {
        try {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
            return $this;
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
    /**
     * Retrieve VisitorLocation.
     *
     * @param int $visitorId
     * @return VisitorLocationInterface
     */
    public function getByVisitorId($visitorId)
    {
        try {
            if (!isset($this->instances[$visitorId])) {
                /** @var VisitorLocationInterface|AbstractModel $VisitorLocation */
                $VisitorLocation = $this->VisitorLocationInterfaceFactory->create();
                $this->resource->load($VisitorLocation, $visitorId, 'visitor_id');
                if (!$VisitorLocation->getId()) {
                    throw new NoSuchEntityException(__('Requested VisitorLocation doesn\'t exist'));
                }
                $this->instances[$visitorId] = $VisitorLocation;
            }
            return $this->instances[$visitorId];
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
    /**
     * Retrieve VisitorLocation.
     *
     * @param int $customerId
     * @return VisitorLocationInterface
     */
    public function getByCustomerId($customerId)
    {
        try {
            if (!isset($this->instances[$customerId])) {
                /** @var VisitorLocationInterface|AbstractModel $VisitorLocation */
                $VisitorLocation = $this->VisitorLocationInterfaceFactory->create();
                $this->resource->load($VisitorLocation, $customerId, 'customer_id');
                if (!$VisitorLocation->getId()) {
                    throw new NoSuchEntityException(__('Requested VisitorLocation doesn\'t exist'));
                }
                $this->instances[$customerId] = $VisitorLocation;
            }
            return $this->instances[$customerId];
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}
