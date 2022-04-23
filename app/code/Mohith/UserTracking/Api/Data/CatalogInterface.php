<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 16/3/22
 * Time: 1:45 PM
 */

namespace Mohith\UserTracking\Api\Data;

/**
 * Interface CatalogInterface
 * @package Mohith\UserTracking\Api\Data
 */
interface CatalogInterface
{
    /**
     * Catalog ID
     *
     * @var int
     */
    const CATALOG_ID = 'catalog_id';
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
     * Product ID
     *
     * @var int
     */
    const PRODUCT_ID = 'product_id';
    /**
     * Product SKU
     *
     * @var string
     */
    const PRODUCT_SKU = 'product_sku';
    /**
     * Category ID
     *
     * @var int
     */
    const CATEGORY_ID = 'category_id';
    /**
     * Category Name
     *
     * @var string
     */
    const CATEGORY_NAME = 'category_name';

    /**
     * Event Type
     *
     * @var string
     */
    const EVENT_TYPE = 'event_type';

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
     * Get CatalogID
     *
     * @return int|null
     */
    public function getCatalogId();

    /**
     * Set CatalogID
     *
     * @param int $categoryId
     * @return CatalogInterface
     */
    public function setCatalogId($categoryId);

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
     * @return CatalogInterface
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
     * Get ProductID
     *
     * @return int|null
     */
    public function getProductId();

    /**
     * Set ProductID
     *
     * @param int $productId
     * @return CatalogInterface
     */
    public function setProductId($productId);

    /**
     * Get ProductSku
     *
     * @return string|null
     */
    public function getProductSku();

    /**
     * Set ProductSku
     *
     * @param string $productSku
     * @return CatalogInterface
     */
    public function setProductSku($productSku);

    /**
     * Get CategoryID
     *
     * @return int|null
     */
    public function getCategoryId();

    /**
     * Set CategoryID
     *
     * @param int $categoryId
     * @return CatalogInterface
     */
    public function setCategoryId($categoryId);

    /**
     * Get CategoryName
     *
     * @return string|null
     */
    public function getCategoryName();

    /**
     * Set CategoryName
     *
     * @param string $categoryName
     * @return CatalogInterface
     */
    public function setCategoryName($categoryName);

    /**
     * Get EventType
     *
     * @return string|null
     */
    public function getEventType();

    /**
     * Set EventType
     *
     * @param string $eventType
     * @return CatalogInterface
     */
    public function setEventType($eventType);

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
     * @return CatalogInterface
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
     * @return CatalogInterface
     */
    public function setUpdatedAt($updatedAt);
}
