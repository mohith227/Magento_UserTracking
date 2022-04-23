<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 2/4/22
 * Time: 12:57 PM
 */

namespace Mohith\UserTracking\Model;

use Magento\Framework\Model\AbstractModel;
use Mohith\UserTracking\Api\Data\VisitorLocationInterface;
use Mohith\UserTracking\Model\ResourceModel\VisitorLocation as VisitorLocationResourceModel;

/**
 * Class VisitorLocation
 * @package Mohith\UserTracking\Model
 */
class VisitorLocation extends AbstractModel implements VisitorLocationInterface
{
    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'mohith_visitor_location';

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
    protected $_eventPrefix = 'mohith_visitor_location';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'visitor_location';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(VisitorLocationResourceModel::class);
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
        return $this->getData(VisitorLocationInterface::ENTITY_ID);
    }

    /**
     * Set EntityID
     *
     * @param int $entityId
     * @return VisitorLocationInterface
     */
    public function setEntityId($entityId)
    {
        return $this->setData(VisitorLocationInterface::ENTITY_ID, $entityId);
    }

    /**
     * Get VisitorID
     *
     * @return int|null
     */
    public function getVisitorId()
    {
        return $this->getData(VisitorLocationInterface::VISITOR_ID);
    }

    /**
     * Set VisitorID
     *
     * @param int $visitorId
     * @return VisitorLocationInterface
     */
    public function setVisitorId($visitorId)
    {
        return $this->setData(VisitorLocationInterface::VISITOR_ID, $visitorId);
    }

    /**
     * Get CustomerID
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->getData(VisitorLocationInterface::CUSTOMER_ID);
    }

    /**
     * Set CustomerID
     *
     * @param int $customerId
     * @return VisitorLocationInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(VisitorLocationInterface::CUSTOMER_ID, $customerId);
    }

    /**
     * Get CustomerEmail
     *
     * @return string|null
     */
    public function getCustomerEmail()
    {
        return $this->getData(VisitorLocationInterface::CUSTOMER_EMAIL);
    }

    /**
     * Set CustomerEmail
     *
     * @param string $customerEmail
     * @return VisitorLocationInterface
     */
    public function setCustomerEmail($customerEmail)
    {
        return $this->setData(VisitorLocationInterface::CUSTOMER_EMAIL, $customerEmail);
    }

    /**
     * Get CustomerGroup
     *
     * @return string|null
     */
    public function getCustomerGroup()
    {
        return $this->getData(VisitorLocationInterface::CUSTOMER_GROUP);
    }


    /**
     * Set CustomerGroup
     *
     * @param string $customerGroup
     * @return VisitorLocationInterface
     */
    public function setCustomerGroup($customerGroup)
    {
        return $this->setData(VisitorLocationInterface::CUSTOMER_GROUP, $customerGroup);
    }
    /**
     * Get IpAddress
     *
     * @return string|null
     */
    public function getIpAddress()
    {
        return $this->getData(VisitorLocationInterface::IP_ADDRESS);
    }

    /**
     * Set IpAddress
     *
     * @param string $ipAddress
     * @return VisitorLocationInterface
     */
    public function setIpAddress($ipAddress)
    {
        return $this->setData(VisitorLocationInterface::IP_ADDRESS, $ipAddress);
    }

    /**
     * Get BrowserOs
     *
     * @return string|null
     */
    public function getBrowserOs()
    {
        return $this->getData(VisitorLocationInterface::BROWSER_OS);
    }

    /**
     * Set BrowserOs
     *
     * @param string $browserOs
     * @return VisitorLocationInterface
     */
    public function setBrowserOs($browserOs)
    {
        return $this->setData(VisitorLocationInterface::BROWSER_OS, $browserOs);
    }

    /**
     * Get CountryName
     *
     * @return string|null
     */
    public function getCountryName()
    {
        return $this->getData(VisitorLocationInterface::COUNTRY_NAME);
    }

    /**
     * Set CountryName
     *
     * @param string $countryName
     * @return VisitorLocationInterface
     */
    public function setCountryName($countryName)
    {
        return $this->setData(VisitorLocationInterface::COUNTRY_NAME, $countryName);
    }

    /**
     * Get CountryCode
     *
     * @return string|null
     */
    public function getCountryCode()
    {
        return $this->getData(VisitorLocationInterface::COUNTRY_CODE);
    }

    /**
     * Set CountryName
     *
     * @param string $countryCode
     * @return VisitorLocationInterface
     */
    public function setCountryCode($countryCode)
    {
        return $this->setData(VisitorLocationInterface::COUNTRY_CODE, $countryCode);
    }

    /**
     * Get RegionName
     *
     * @return string|null
     */
    public function getRegionName()
    {
        return $this->getData(VisitorLocationInterface::REGION_NAME);
    }

    /**
     * Set RegionName
     *
     * @param string $regionName
     * @return VisitorLocationInterface
     */
    public function setRegionName($regionName)
    {
        return $this->setData(VisitorLocationInterface::REGION_NAME, $regionName);
    }

    /**
     * Get RegionCode
     *
     * @return string|null
     */
    public function getRegionCode()
    {
        return $this->getData(VisitorLocationInterface::REGION_CODE);
    }

    /**
     * Set RegionCode
     *
     * @param string $regionCode
     * @return VisitorLocationInterface
     */
    public function setRegionCode($regionCode)
    {
        return $this->setData(VisitorLocationInterface::REGION_CODE, $regionCode);
    }

    /**
     * Get City
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->getData(VisitorLocationInterface::CITY);
    }

    /**
     * Set City
     *
     * @param string $city
     * @return VisitorLocationInterface
     */
    public function setCity($city)
    {
        return $this->setData(VisitorLocationInterface::CITY, $city);
    }

    /**
     * Get ZipCode
     *
     * @return string|null
     */
    public function getZipCode()
    {
        return $this->getData(VisitorLocationInterface::ZIP_CODE);
    }

    /**
     * Set ZipCode
     *
     * @param string $zipCode
     * @return VisitorLocationInterface
     */
    public function setZipCode($zipCode)
    {
        return $this->setData(VisitorLocationInterface::ZIP_CODE, $zipCode);
    }

    /**
     * Get TimeZone
     *
     * @return string|null
     */
    public function getTimeZone()
    {
        return $this->getData(VisitorLocationInterface::TIME_ZONE);
    }

    /**
     * Set TimeZone
     *
     * @param string $timeZone
     * @return VisitorLocationInterface
     */
    public function setTimeZone($timeZone)
    {
        return $this->setData(VisitorLocationInterface::TIME_ZONE, $timeZone);
    }

    /**
     * Get created at time
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(VisitorLocationInterface::CREATED_AT);
    }

    /**
     * Set created at time
     *
     * @param string $createdAt
     * @return VisitorLocationInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(VisitorLocationInterface::CREATED_AT, $createdAt);
    }

    /**
     * Get updated at time
     *
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(VisitorLocationInterface::UPDATED_AT);
    }

    /**
     * Set updated at time
     *
     * @param string $updatedAt
     * @return VisitorLocationInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(VisitorLocationInterface::UPDATED_AT, $updatedAt);
    }
}
