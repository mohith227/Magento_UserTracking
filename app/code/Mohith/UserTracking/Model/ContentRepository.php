<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 17/3/22
 * Time: 3:37 PM
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
use Mohith\UserTracking\Api\ContentRepositoryInterface;
use Mohith\UserTracking\Api\Data\ContentInterface;
use Mohith\UserTracking\Api\Data\ContentInterfaceFactory;
use Mohith\UserTracking\Api\Data\ContentSearchResultInterface;
use Mohith\UserTracking\Api\Data\ContentSearchResultInterfaceFactory;
use Mohith\UserTracking\Model\ResourceModel\Content as ContentResourceModel;
use Mohith\UserTracking\Model\ResourceModel\Content\Collection;
use Mohith\UserTracking\Model\ResourceModel\Content\CollectionFactory as ContentCollectionFactory;
use Psr\Log\LoggerInterface;

/**
 * Class ContentRepository
 * @package Mohith\UserTracking\Model
 */
class ContentRepository implements ContentRepositoryInterface
{
    /**
     * Cached instances
     *
     * @var array
     */
    protected $instances = [];

    /**
     * Content resource model
     *
     * @var ContentResourceModel
     */
    protected $resource;

    /**
     * Content collection factory
     *
     * @var ContentCollectionFactory
     */
    protected $contentCollectionFactory;

    /**
     * Content interface factory
     *
     * @var ContentInterfaceFactory
     */
    protected $contentInterfaceFactory;

    /**
     * Data Object Helper
     *
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Search result factory
     *
     * @var ContentSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * ContentRepository constructor.
     * @param ContentResourceModel $resource
     * @param ContentCollectionFactory $contentCollectionFactory
     * @param ContentInterfaceFactory $contentInterfaceFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ContentSearchResultInterfaceFactory $searchResultsFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        ContentResourceModel $resource,
        ContentCollectionFactory $contentCollectionFactory,
        ContentInterfaceFactory $contentInterfaceFactory,
        DataObjectHelper $dataObjectHelper,
        ContentSearchResultInterfaceFactory $searchResultsFactory,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->contentCollectionFactory = $contentCollectionFactory;
        $this->contentInterfaceFactory = $contentInterfaceFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->logger = $logger;
    }

    /**
     * Save Content.
     *
     * @param ContentInterface $content
     * @return AbstractModel|ContentInterface
     */
    public function save(ContentInterface $content)
    {
        try {

            /** @var ContentInterface|AbstractModel $content */
            try {
                $this->resource->save($content);
            } catch (\Exception $exception) {
                throw new CouldNotSaveException(__(
                    'Could not save the Content: %1',
                    $exception->getMessage()
                ));
            }
            return $content;
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Retrieve Content.
     *
     * @param int $contentId
     * @return ContentInterface
     */
    public function getById($contentId)
    {
        try {
            if (!isset($this->instances[$contentId])) {
                /** @var ContentInterface|AbstractModel $content */
                $content = $this->contentInterfaceFactory->create();
                $this->resource->load($content, $contentId);
                if (!$content->getId()) {
                    throw new NoSuchEntityException(__('Requested Content doesn\'t exist'));
                }
                $this->instances[$contentId] = $content;
            }
            return $this->instances[$contentId];
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Retrieve Content matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return ContentSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        try {
            try {

                /** @var ContentSearchResultInterface $searchResults */
                $searchResults = $this->searchResultsFactory->create();
                $searchResults->setSearchCriteria($searchCriteria);

                /** @var Collection $collection */
                $collection = $this->contentCollectionFactory->create();

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
                    $field = 'content_id';
                    $collection->addOrder($field, 'ASC');
                }
                $collection->setCurPage($searchCriteria->getCurrentPage());
                $collection->setPageSize($searchCriteria->getPageSize());

                /** @var ContentInterface[] $team */
                $team = [];
                /** @var Content $content */
                foreach ($collection as $content) {
                    /** @var ContentInterface $contentDataObject */
                    $contentDataObject = $this->contentInterfaceFactory->create();
                    $this->dataObjectHelper->populateWithArray(
                        $contentDataObject,
                        $content->getData(),
                        ContentInterface::class
                    );
                    $team[] = $contentDataObject;
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
     * Delete Content.
     *
     * @param ContentInterface $content
     * @return bool true on success
     */
    public function delete(ContentInterface $content)
    {
        try {

            /** @var ContentInterface|AbstractModel $content */
            $id = $content->getId();
            try {
                unset($this->instances[$id]);
                $this->resource->delete($content);
            } catch (ValidatorException $e) {
                throw new CouldNotSaveException(__($e->getMessage()));
            } catch (\Exception $e) {
                throw new StateException(
                    __('Unable to remove Content %1', $id)
                );
            }
            unset($this->instances[$id]);
            return true;
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Delete Content by ID.
     *
     * @param int $contentId
     * @return bool true on success
     */
    public function deleteById($contentId)
    {
        try {
            $content = $this->getById($contentId);
            return $this->delete($content);
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
