<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 15/3/22
 * Time: 2:52 PM
 */

namespace Mohith\UserTracking\Api\Data;

/**
 * Interface VisitorInterface
 * @package Mohith\UserTracking\Api\Data
 */
interface VisitorInterface
{
    /**
     * Entity ID
     *
     * @var int
     */
    const ENTITY_ID = 'entity_id';
    /**
     * Visitor ID
     *
     * @var int
     */
    const VISITOR_ID = 'visitor_id';
    /**
     * Session ID
     *
     * @var string
     */
    const SESSION_ID = 'session_id';
    /**
     * Ip Address
     *
     * @var string
     */
    const IP_ADDRESS = 'ip_address';
    /**
     * Latitude
     *
     * @var string
     */
    const LATITUDE = 'latitude';
    /**
     * Longitude
     *
     * @var string
     */
    const LONGITUDE = 'longitude';
    /**
     * Created At
     *
     * @var string
     */
    const CREATED_AT = 'created_at';
    /**
     * Updated At
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /**
     * Get  EntityID
     *
     * @return int|null
     */
    public function getEntityId();

    /**
     * Set EntityID
     *
     * @param int $entityId
     * @return VisitorInterface
     */
    public function setEntityId($entityId);

    /**
     * Get VisitorID
     *
     * @return int|null
     */
    public function getVisitorId();

    /**
     * Set VisitorID
     *
     * @param int $visitorId
     * @return VisitorInterface
     */
    public function setVisitorId($visitorId);

    /**
     * Get SessionID
     *
     * @return string|null
     */
    public function getSessionId();

    /**
     * Set SessionID
     *
     * @param string $sessionId
     * @return VisitorInterface
     */
    public function setSessionId($sessionId);

    /**
     * Get IpAddress
     *
     * @return string|null
     */
    public function getIpAddress();

    /**
     * Set IpAddress
     *
     * @param string $ipAddress
     * @return VisitorInterface
     */
    public function setIpAddress($ipAddress);

    /**
     * Get Latitude
     *
     * @return string|null
     */
    public function getLatitude();

    /**
     * Set Latitude
     *
     * @param string $latitude
     * @return VisitorInterface
     */
    public function setLatitude($latitude);

    /**
     * Get Longitude
     *
     * @return string|null
     */
    public function getLongitude();

    /**
     * Set Longitude
     *
     * @param string $longitude
     * @return VisitorInterface
     */
    public function setLongitude($longitude);

    /**
     * Get created at time
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created at time
     *
     * @param string $createdAt
     * @return VisitorInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated at time
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated at time
     *
     * @param string $updatedAt
     * @return VisitorInterface
     */
    public function setUpdatedAt($updatedAt);
}
