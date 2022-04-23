<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 15/3/22
 * Time: 4:13 PM
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
use Mohith\UserTracking\Api\Data\VisitorInterface;
use Mohith\UserTracking\Api\Data\VisitorInterfaceFactory;
use Mohith\UserTracking\Api\Data\VisitorSearchResultInterface;
use Mohith\UserTracking\Api\Data\VisitorSearchResultInterfaceFactory;
use Mohith\UserTracking\Api\VisitorRepositoryInterface;
use Mohith\UserTracking\Model\ResourceModel\Visitor as VisitorResourceModel;
use Mohith\UserTracking\Model\ResourceModel\Visitor\Collection;
use Mohith\UserTracking\Model\ResourceModel\Visitor\CollectionFactory as VisitorCollectionFactory;
use Psr\Log\LoggerInterface;

/**
 * Class VisitorRepository
 * @package Mohith\UserTracking\Model
 */
class VisitorRepository implements VisitorRepositoryInterface
{
    /**
     * Cached instances
     *
     * @var array
     */
    protected $instances = [];

    /**
     * Visitor resource model
     *
     * @var VisitorResourceModel
     */
    protected $resource;

    /**
     * Visitor collection factory
     *
     * @var VisitorCollectionFactory
     */
    protected $visitorCollectionFactory;

    /**
     * Visitor interface factory
     *
     * @var VisitorInterfaceFactory
     */
    protected $visitorInterfaceFactory;

    /**
     * Data Object Helper
     *
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Search result factory
     *
     * @var VisitorSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * VisitorRepository constructor.
     *
     * @param VisitorResourceModel $resource
     * @param VisitorCollectionFactory $visitorCollectionFactory
     * @param VisitorInterfaceFactory $visitorInterfaceFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param VisitorSearchResultInterfaceFactory $searchResultsFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        VisitorResourceModel $resource,
        VisitorCollectionFactory $visitorCollectionFactory,
        VisitorInterfaceFactory $visitorInterfaceFactory,
        DataObjectHelper $dataObjectHelper,
        VisitorSearchResultInterfaceFactory $searchResultsFactory,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->visitorCollectionFactory = $visitorCollectionFactory;
        $this->visitorInterfaceFactory = $visitorInterfaceFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->logger = $logger;
    }

    /**
     * Save Visitor.
     *
     * @param VisitorInterface $visitor
     * @return AbstractModel|VisitorInterface
     */
    public function save(VisitorInterface $visitor)
    {
        try {

            /** @var VisitorInterface|AbstractModel $visitor */
            try {
                $this->resource->save($visitor);
            } catch (\Exception $exception) {
                throw new CouldNotSaveException(__(
                    'Could not save the Visitor: %1',
                    $exception->getMessage()
                ));
            }
            return $visitor;
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Retrieve Visitor.
     *
     * @param int $visitorId
     * @return VisitorInterface
     */
    public function getById($visitorId)
    {
        try {
            if (!isset($this->instances[$visitorId])) {
                /** @var VisitorInterface|AbstractModel $visitor */
                $visitor = $this->visitorInterfaceFactory->create();
                $this->resource->load($visitor, $visitorId);
                if (!$visitor->getId()) {
                    throw new NoSuchEntityException(__('Requested Visitor doesn\'t exist'));
                }
                $this->instances[$visitorId] = $visitor;
            }
            return $this->instances[$visitorId];
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Retrieve Visitor matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return VisitorSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        try {
            try {

                /** @var VisitorSearchResultInterface $searchResults */
                $searchResults = $this->searchResultsFactory->create();
                $searchResults->setSearchCriteria($searchCriteria);

                /** @var Collection $collection */
                $collection = $this->visitorCollectionFactory->create();

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
                    $field = 'visitor_id';
                    $collection->addOrder($field, 'ASC');
                }
                $collection->setCurPage($searchCriteria->getCurrentPage());
                $collection->setPageSize($searchCriteria->getPageSize());

                /** @var VisitorInterface[] $team */
                $team = [];
                /** @var Visitor $visitor */
                foreach ($collection as $visitor) {
                    /** @var VisitorInterface $visitorDataObject */
                    $visitorDataObject = $this->visitorInterfaceFactory->create();
                    $this->dataObjectHelper->populateWithArray(
                        $visitorDataObject,
                        $visitor->getData(),
                        VisitorInterface::class
                    );
                    $team[] = $visitorDataObject;
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
     * Delete Visitor.
     *
     * @param VisitorInterface $visitor
     * @return bool true on success
     */
    public function delete(VisitorInterface $visitor)
    {
        try {

            /** @var VisitorInterface|AbstractModel $visitor */
            $id = $visitor->getId();
            try {
                unset($this->instances[$id]);
                $this->resource->delete($visitor);
            } catch (ValidatorException $e) {
                throw new CouldNotSaveException(__($e->getMessage()));
            } catch (\Exception $e) {
                throw new StateException(
                    __('Unable to remove Visitor %1', $id)
                );
            }
            unset($this->instances[$id]);
            return true;
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Delete Visitor by ID.
     *
     * @param int $visitorId
     * @return bool true on success
     */
    public function deleteById($visitorId)
    {
        try {
            $visitor = $this->getById($visitorId);
            return $this->delete($visitor);
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
     * Retrieve Visitor.
     *
     * @param string $sessionId
     * @return VisitorInterface
     */
    public function getBySessionId($sessionId)
    {
        try {
            if (!isset($this->instances[$sessionId])) {
                /** @var VisitorInterface|AbstractModel $visitor */
                $visitor = $this->visitorInterfaceFactory->create();
                $this->resource->load($visitor, $sessionId, 'session_id');
                if (!$visitor->getId()) {
                    throw new NoSuchEntityException(__('Requested Visitor doesn\'t exist'));
                }
                $this->instances[$sessionId] = $visitor;
            }
            return $this->instances[$sessionId];
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
    /**
     * Retrieve Visitor.
     *
     * @param string $latitude
     * @return VisitorInterface
     */
    public function getByLatitude($latitude)
    {
        try {
            if (!isset($this->instances[$latitude])) {
                /** @var VisitorInterface|AbstractModel $visitor */
                $visitor = $this->visitorInterfaceFactory->create();
                $this->resource->load($visitor, $latitude, 'latitude');
                if (!$visitor->getId()) {
                    throw new NoSuchEntityException(__('Requested Visitor doesn\'t exist'));
                }
                $this->instances[$latitude] = $visitor;
            }
            return $this->instances[$latitude];
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
    /**
     * Retrieve Visitor.
     *
     * @param string $ipAddress
     * @return VisitorInterface
     */
    public function getByIP($ipAddress)
    {
        try {
            if (!isset($this->instances[$ipAddress])) {
                /** @var VisitorInterface|AbstractModel $visitor */
                $visitor = $this->visitorInterfaceFactory->create();
                $this->resource->load($visitor, $ipAddress, 'ip_address');
                if (!$visitor->getId()) {
                    throw new NoSuchEntityException(__('Requested Visitor doesn\'t exist'));
                }
                $this->instances[$ipAddress] = $visitor;
            }
            return $this->instances[$ipAddress];
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}
