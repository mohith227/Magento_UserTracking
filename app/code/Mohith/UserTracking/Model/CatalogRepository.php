<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 16/3/22
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
use Mohith\UserTracking\Api\CatalogRepositoryInterface;
use Mohith\UserTracking\Api\Data\CatalogInterface;
use Mohith\UserTracking\Api\Data\CatalogInterfaceFactory;
use Mohith\UserTracking\Api\Data\CatalogSearchResultInterface;
use Mohith\UserTracking\Api\Data\CatalogSearchResultInterfaceFactory;
use Mohith\UserTracking\Model\ResourceModel\Catalog as CatalogResourceModel;
use Mohith\UserTracking\Model\ResourceModel\Catalog\Collection;
use Mohith\UserTracking\Model\ResourceModel\Catalog\CollectionFactory as CatalogCollectionFactory;
use Psr\Log\LoggerInterface;

/**
 * Class CatalogRepository
 * @package Mohith\UserTracking\Model
 */
class CatalogRepository implements CatalogRepositoryInterface
{
    /**
     * Cached instances
     *
     * @var array
     */
    protected $instances = [];

    /**
     * Catalog resource model
     *
     * @var CatalogResourceModel
     */
    protected $resource;

    /**
     * Catalog collection factory
     *
     * @var CatalogCollectionFactory
     */
    protected $catalogCollectionFactory;

    /**
     * Catalog interface factory
     *
     * @var CatalogInterfaceFactory
     */
    protected $catalogInterfaceFactory;

    /**
     * Data Object Helper
     *
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Search result factory
     *
     * @var CatalogSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * CatalogRepository constructor.
     * @param CatalogResourceModel $resource
     * @param CatalogCollectionFactory $catalogCollectionFactory
     * @param CatalogInterfaceFactory $catalogInterfaceFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param CatalogSearchResultInterfaceFactory $searchResultsFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        CatalogResourceModel $resource,
        CatalogCollectionFactory $catalogCollectionFactory,
        CatalogInterfaceFactory $catalogInterfaceFactory,
        DataObjectHelper $dataObjectHelper,
        CatalogSearchResultInterfaceFactory $searchResultsFactory,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->catalogCollectionFactory = $catalogCollectionFactory;
        $this->catalogInterfaceFactory = $catalogInterfaceFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->logger = $logger;
    }

    /**
     * Save Catalog.
     *
     * @param CatalogInterface $catalog
     * @return AbstractModel|CatalogInterface
     */
    public function save(CatalogInterface $catalog)
    {
        try {

            /** @var CatalogInterface|AbstractModel $catalog */
            try {
                $this->resource->save($catalog);
            } catch (\Exception $exception) {
                throw new CouldNotSaveException(__(
                    'Could not save the Catalog: %1',
                    $exception->getMessage()
                ));
            }
            return $catalog;
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Retrieve Catalog.
     *
     * @param int $catalogId
     * @return CatalogInterface
     */
    public function getById($catalogId)
    {
        try {
            if (!isset($this->instances[$catalogId])) {
                /** @var CatalogInterface|AbstractModel $catalog */
                $catalog = $this->catalogInterfaceFactory->create();
                $this->resource->load($catalog, $catalogId);
                if (!$catalog->getId()) {
                    throw new NoSuchEntityException(__('Requested Catalog doesn\'t exist'));
                }
                $this->instances[$catalogId] = $catalog;
            }
            return $this->instances[$catalogId];
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Retrieve Catalog matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CatalogSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        try {
            try {

                /** @var CatalogSearchResultInterface $searchResults */
                $searchResults = $this->searchResultsFactory->create();
                $searchResults->setSearchCriteria($searchCriteria);

                /** @var Collection $collection */
                $collection = $this->catalogCollectionFactory->create();

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
                    $field = 'catalog_id';
                    $collection->addOrder($field, 'ASC');
                }
                $collection->setCurPage($searchCriteria->getCurrentPage());
                $collection->setPageSize($searchCriteria->getPageSize());

                /** @var CatalogInterface[] $team */
                $team = [];
                /** @var Catalog $catalog */
                foreach ($collection as $catalog) {
                    /** @var CatalogInterface $catalogDataObject */
                    $catalogDataObject = $this->catalogInterfaceFactory->create();
                    $this->dataObjectHelper->populateWithArray(
                        $catalogDataObject,
                        $catalog->getData(),
                        CatalogInterface::class
                    );
                    $team[] = $catalogDataObject;
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
     * Delete Catalog.
     *
     * @param CatalogInterface $catalog
     * @return bool true on success
     */
    public function delete(CatalogInterface $catalog)
    {
        try {

            /** @var CatalogInterface|AbstractModel $catalog */
            $id = $catalog->getId();
            try {
                unset($this->instances[$id]);
                $this->resource->delete($catalog);
            } catch (ValidatorException $e) {
                throw new CouldNotSaveException(__($e->getMessage()));
            } catch (\Exception $e) {
                throw new StateException(
                    __('Unable to remove Catalog %1', $id)
                );
            }
            unset($this->instances[$id]);
            return true;
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Delete Catalog by ID.
     *
     * @param int $catalogId
     * @return bool true on success
     */
    public function deleteById($catalogId)
    {
        try {
            $catalog = $this->getById($catalogId);
            return $this->delete($catalog);
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
}
