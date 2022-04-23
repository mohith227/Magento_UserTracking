<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 2/4/22
 * Time: 12:37 PM
 */

namespace Mohith\UserTracking\Api\Data;

/**
 * Interface VisitorLocationInterface
 * @package Mohith\UserTracking\Api\Data
 */
interface VisitorLocationInterface
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
     * Customer ID
     *
     * @var int
     */
    const CUSTOMER_ID = 'customer_id';
    /**
     * Customer Email
     *
     * @var string
     */
    const CUSTOMER_EMAIL = 'customer_email';
    /**
     * Customer Group
     *
     * @var string
     */
    const CUSTOMER_GROUP = 'customer_group';
    /**
     * Ip Address
     *
     * @var string
     */
    const IP_ADDRESS = 'ip_address';
    /**
     * Browser OS
     *
     * @var string
     */
    const BROWSER_OS = 'browser_os';
    /**
     * Country Name
     *
     * @var string
     */
    const COUNTRY_NAME = 'country_name';
    /**
     * Country Code
     *
     * @var string
     */
    const COUNTRY_CODE = 'country_code';
    /**
     * Region Name
     *
     * @var string
     */
    const REGION_NAME = 'region_name';
    /**
     *Region Code
     *
     * @var string
     */
    const REGION_CODE = 'region_code';
    /**
     * City
     *
     * @var string
     */
    const CITY = 'city';
    /**
     * Zip Code
     *
     * @var string
     */
    const ZIP_CODE = 'zip_code';
    /**
     * Time Zone
     *
     * @var string
     */
    const TIME_ZONE = 'time_zone';
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
     * Get CustomerID
     *
     * @return int|null
     */
    public function getCustomerId();

    /**
     * Set CustomerID
     *
     * @param int $customerId
     * @return CatalogInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get CustomerEmail
     *
     * @return string|null
     */
    public function getCustomerEmail();

    /**
     * Set CustomerEmail
     *
     * @param string $customerEmail
     * @return CatalogInterface
     */
    public function setCustomerEmail($customerEmail);

    /**
     * Get CustomerGroup
     *
     * @return string|null
     */
    public function getCustomerGroup();

    /**
     * Set CustomerGroup
     *
     * @param string $customerGroup
     * @return CatalogInterface
     */
    public function setCustomerGroup($customerGroup);

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
     * Get BrowserOs
     *
     * @return string|null
     */
    public function getBrowserOs();

    /**
     * Set BrowserOs
     *
     * @param string $browserOs
     * @return VisitorInterface
     */
    public function setBrowserOs($browserOs);

    /**
     * Get CountryName
     *
     * @return string|null
     */
    public function getCountryName();

    /**
     * Set CountryName
     *
     * @param string $countryName
     * @return VisitorInterface
     */
    public function setCountryName($countryName);

    /**
     * Get CountryCode
     *
     * @return string|null
     */
    public function getCountryCode();

    /**
     * Set CountryName
     *
     * @param string $countryCode
     * @return VisitorInterface
     */
    public function setCountryCode($countryCode);

    /**
     * Get RegionName
     *
     * @return string|null
     */
    public function getRegionName();

    /**
     * Set RegionName
     *
     * @param string $regionName
     * @return VisitorInterface
     */
    public function setRegionName($regionName);

    /**
     * Get RegionCode
     *
     * @return string|null
     */
    public function getRegionCode();

    /**
     * Set RegionCode
     *
     * @param string $regionCode
     * @return VisitorInterface
     */
    public function setRegionCode($regionCode);

    /**
     * Get City
     *
     * @return string|null
     */
    public function getCity();

    /**
     * Set City
     *
     * @param string $city
     * @return VisitorInterface
     */
    public function setCity($city);

    /**
     * Get ZipCode
     *
     * @return string|null
     */
    public function getZipCode();

    /**
     * Set ZipCode
     *
     * @param string $zipCode
     * @return VisitorInterface
     */
    public function setZipCode($zipCode);

    /**
     * Get TimeZone
     *
     * @return string|null
     */
    public function getTimeZone();

    /**
     * Set TimeZone
     *
     * @param string $timeZone
     * @return VisitorInterface
     */
    public function setTimeZone($timeZone);

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
