<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 15/3/22
 * Time: 3:52 PM
 */

namespace Mohith\UserTracking\Model;

use Magento\Framework\Model\AbstractModel;
use Mohith\UserTracking\Api\Data\VisitorInterface;
use Mohith\UserTracking\Model\ResourceModel\Visitor as VisitorResourceModel;

/**
 * Class Visitor
 * @package Mohith\UserTracking\Model
 */
class Visitor extends AbstractModel implements VisitorInterface
{

    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'mohith_visitor';

    /**
     * Cache tag
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'mohith_visitor';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'visitor';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(VisitorResourceModel::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get  EntityID
     *
     * @return int|null
     */
    public function getEntityId()
    {
        return $this->getData(VisitorInterface::ENTITY_ID);
    }

    /**
     * Set EntityID
     *
     * @param int $entityId
     * @return VisitorInterface
     */
    public function setEntityId($entityId)
    {
        return $this->setData(VisitorInterface::ENTITY_ID, $entityId);
    }

    /**
     * Get VisitorID
     *
     * @return int|null
     */
    public function getVisitorId()
    {
        return $this->getData(VisitorInterface::VISITOR_ID);
    }

    /**
     * Set VisitorID
     *
     * @param int $visitorId
     * @return VisitorInterface
     */
    public function setVisitorId($visitorId)
    {
        return $this->setData(VisitorInterface::VISITOR_ID, $visitorId);
    }

    /**
     * Get SessionID
     *
     * @return string|null
     */
    public function getSessionId()
    {
        return $this->getData(VisitorInterface::SESSION_ID);
    }

    /**
     * Set SessionID
     *
     * @param string $sessionId
     * @return VisitorInterface
     */
    public function setSessionId($sessionId)
    {
        return $this->setData(VisitorInterface::SESSION_ID, $sessionId);
    }

    /**
     * Get IpAddress
     *
     * @return string|null
     */
    public function getIpAddress()
    {
        return $this->getData(VisitorInterface::IP_ADDRESS);
    }

    /**
     * Set IpAddress
     *
     * @param string $ipAddress
     * @return VisitorInterface
     */
    public function setIpAddress($ipAddress)
    {
        return $this->setData(VisitorInterface::IP_ADDRESS, $ipAddress);
    }

    /**
     * Get Latitude
     *
     * @return string|null
     */
    public function getLatitude()
    {
        return $this->getData(VisitorInterface::LATITUDE);
    }

    /**
     * Set Latitude
     *
     * @param string $latitude
     * @return VisitorInterface
     */
    public function setLatitude($latitude)
    {
        return $this->setData(VisitorInterface::LATITUDE, $latitude);
    }

    /**
     * Get Longitude
     *
     * @return string|null
     */
    public function getLongitude()
    {
        return $this->getData(VisitorInterface::LONGITUDE);
    }

    /**
     * Set Longitude
     *
     * @param string $longitude
     * @return VisitorInterface
     */
    public function setLongitude($longitude)
    {
        return $this->setData(VisitorInterface::LONGITUDE, $longitude);
    }

    /**
     * Get created at time
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(VisitorInterface::CREATED_AT);
    }

    /**
     * Set created at time
     *
     * @param string $createdAt
     * @return VisitorInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(VisitorInterface::CREATED_AT, $createdAt);
    }

    /**
     * Get updated at time
     *
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(VisitorInterface::UPDATED_AT);
    }

    /**
     * Set updated at time
     *
     * @param string $updatedAt
     * @return VisitorInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(VisitorInterface::UPDATED_AT, $updatedAt);
    }
}
