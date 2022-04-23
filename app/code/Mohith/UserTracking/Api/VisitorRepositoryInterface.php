<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 15/3/22
 * Time: 3:32 PM
 */

namespace Mohith\UserTracking\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Mohith\UserTracking\Api\Data\VisitorInterface;
use Mohith\UserTracking\Api\Data\VisitorSearchResultInterface;

/**
 * Interface VisitorRepositoryInterface
 * @package Mohith\Visitor\Api
 */
interface VisitorRepositoryInterface
{
    /**
     * Save Visitor.
     *
     * @param VisitorInterface $visitor
     * @return VisitorInterface
     */
    public function save(VisitorInterface $visitor);

    /**
     * Retrieve Visitor.
     *
     * @param int $visitorId
     * @return VisitorInterface
     */
    public function getById($visitorId);

    /**
     * Retrieve Visitor matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return VisitorSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Visitor.
     *
     * @param VisitorInterface $visitor
     * @return bool true on success
     */
    public function delete(VisitorInterface $visitor);

    /**
     * Delete Visitor by ID.
     *
     * @param int $visitorId
     * @return bool true on success
     */
    public function deleteById($visitorId);
    /**
     * Retrieve Visitor.
     *
     * @param string $ipAddress
     * @return VisitorInterface
     */
    public function getByIP($ipAddress);
    /**
     * Retrieve Visitor.
     *
     * @param string $sessionId
     * @return VisitorInterface
     */
    public function getBySessionId($sessionId);
    /**
     * Retrieve Visitor.
     *
     * @param string $latitude
     * @return VisitorInterface
     */
    public function getByLatitude($latitude);
}