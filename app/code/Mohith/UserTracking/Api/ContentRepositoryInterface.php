<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 17/3/22
 * Time: 11:47 AM
 */

namespace Mohith\UserTracking\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Mohith\UserTracking\Api\Data\ContentInterface;
use Mohith\UserTracking\Api\Data\ContentSearchResultInterface;

/**
 * Interface ContentRepositoryInterface
 * @package Mohith\UserTracking\Api
 */
interface ContentRepositoryInterface
{
    /**
     * Save Content.
     *
     * @param ContentInterface $content
     * @return ContentInterface
     */
    public function save(ContentInterface $content);

    /**
     * Retrieve Content.
     *
     * @param int $contentId
     * @return ContentInterface
     */
    public function getById($contentId);

    /**
     * Retrieve Content matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return ContentSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Content.
     *
     * @param ContentInterface $content
     * @return bool true on success
     */
    public function delete(ContentInterface $content);

    /**
     * Delete Content by ID.
     *
     * @param int $contentId
     * @return bool true on success
     */
    public function deleteById($contentId);
}