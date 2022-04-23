<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 2/4/22
 * Time: 12:46 PM
 */

namespace Mohith\UserTracking\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Mohith\UserTracking\Api\Data\VisitorLocationInterface;
use Mohith\UserTracking\Api\Data\VisitorLocationSearchResultInterface;
/**
 * Interface VisitorLocationRepositoryInterface
 * @package Mohith\UserTracking\Api
 */
interface VisitorLocationRepositoryInterface
{
    /**
     * Save VisitorLocation.
     *
     * @param VisitorLocationInterface $visitorLocation
     * @return VisitorLocationInterface
     */
    public function save(VisitorLocationInterface $visitorLocation);

    /**
     * Retrieve VisitorLocation.
     *
     * @param int $entityId
     * @return VisitorLocationInterface
     */
    public function getById($entityId);

    /**
     * Retrieve Visitor matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return VisitorLocationSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Visitor.
     *
     * @param VisitorLocationInterface $visitorLocation
     * @return bool true on success
     */
    public function delete(VisitorLocationInterface $visitorLocation);

    /**
     * Delete Visitor by ID.
     *
     * @param int $entityId
     * @return bool true on success
     */
    public function deleteById($entityId);
    /**
     * Retrieve VisitorLocation.
     *
     * @param int $visitorId
     * @return VisitorLocationInterface
     */
    public function getByVisitorId($visitorId);
    /**
     * Retrieve VisitorLocation.
     *
     * @param int $customerId
     * @return VisitorLocationInterface
     */
    public function getByCustomerId($customerId);
}