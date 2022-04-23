<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 16/3/22
 * Time: 3:37 PM
 */

namespace Mohith\UserTracking\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Mohith\UserTracking\Api\Data\CatalogInterface;
use Mohith\UserTracking\Api\Data\CatalogSearchResultInterface;

/**
 * Interface CatalogRepositoryInterface
 * @package Mohith\UserTracking\Api
 */
interface CatalogRepositoryInterface
{
    /**
     * Save Catalog.
     *
     * @param CatalogInterface $catalog
     * @return CatalogInterface
     */
    public function save(CatalogInterface $catalog);

    /**
     * Retrieve Catalog.
     *
     * @param int $catalogId
     * @return CatalogInterface
     */
    public function getById($catalogId);

    /**
     * Retrieve Catalog matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CatalogSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Catalog.
     *
     * @param CatalogInterface $catalog
     * @return bool true on success
     */
    public function delete(CatalogInterface $catalog);

    /**
     * Delete Catalog by ID.
     *
     * @param int $catalogId
     * @return bool true on success
     */
    public function deleteById($catalogId);
}