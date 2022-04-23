<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 16/3/22
 * Time: 3:49 PM
 */

namespace Mohith\UserTracking\Model;

use Magento\Framework\Model\AbstractModel;
use Mohith\UserTracking\Api\Data\CatalogInterface;
use Mohith\UserTracking\Model\ResourceModel\Catalog as CatalogModel;

/**
 * Class Catalog
 * @package Mohith\UserTracking\Model
 */
class Catalog extends AbstractModel implements CatalogInterface
{
    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'mohith_catalog';

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
    protected $_eventPrefix = 'mohith_catalog';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'catalog';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(CatalogModel::class);
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
     * Get CatalogID
     *
     * @return int|null
     */
    public function getCatalogId()
    {
        return $this->getData(CatalogInterface::CATALOG_ID);
    }

    /**
     * Set CatalogID
     *
     * @param int $categoryId
     * @return CatalogInterface
     */
    public function setCatalogId($categoryId)
    {
        return $this->setData(CatalogInterface::CATALOG_ID, $categoryId);
    }

    /**
     * Get VisitorID
     *
     * @return int|null
     */
    public function getVisitorId()
    {
        return $this->getData(CatalogInterface::VISITOR_ID);
    }

    /**
     * Set VisitorID
     *
     * @param int $visitorId
     * @return CatalogInterface
     */
    public function setVisitorId($visitorId)
    {
        return $this->setData(CatalogInterface::VISITOR_ID, $visitorId);
    }

    /**
     * Get CustomerID
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->getData(CatalogInterface::CUSTOMER_ID);
    }

    /**
     * Set CustomerID
     *
     * @param int $customerId
     * @return CatalogInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(CatalogInterface::CUSTOMER_ID, $customerId);
    }

    /**
     * Get CustomerEmail
     *
     * @return string|null
     */
    public function getCustomerEmail()
    {
        return $this->getData(CatalogInterface::CUSTOMER_EMAIL);
    }

    /**
     * Set CustomerEmail
     *
     * @param string $customerEmail
     * @return CatalogInterface
     */
    public function setCustomerEmail($customerEmail)
    {
        return $this->setData(CatalogInterface::CUSTOMER_EMAIL, $customerEmail);
    }

    /**
     * Get CustomerGroup
     *
     * @return string|null
     */
    public function getCustomerGroup()
    {
        return $this->getData(CatalogInterface::CUSTOMER_GROUP);
    }

    /**
     * Set CustomerGroup
     *
     * @param string $customerGroup
     * @return CatalogInterface
     */
    public function setCustomerGroup($customerGroup)
    {
        return $this->setData(CatalogInterface::CUSTOMER_GROUP, $customerGroup);
    }

    /**
     * Get ProductID
     *
     * @return int|null
     */
    public function getProductId()
    {
        return $this->getData(CatalogInterface::PRODUCT_ID);
    }

    /**
     * Set ProductID
     *
     * @param int $productId
     * @return CatalogInterface
     */
    public function setProductId($productId)
    {
        return $this->setData(CatalogInterface::PRODUCT_ID, $productId);
    }

    /**
     * Get ProductSku
     *
     * @return string|null
     */
    public function getProductSku()
    {
        return $this->getData(CatalogInterface::PRODUCT_SKU);
    }

    /**
     * Set ProductSku
     *
     * @param string $productSku
     * @return CatalogInterface
     */
    public function setProductSku($productSku)
    {
        return $this->setData(CatalogInterface::PRODUCT_SKU, $productSku);
    }

    /**
     * Get CategoryID
     *
     * @return int|null
     */
    public function getCategoryId()
    {
        return $this->getData(CatalogInterface::CATEGORY_ID);
    }

    /**
     * Set CategoryID
     *
     * @param int $categoryId
     * @return CatalogInterface
     */
    public function setCategoryId($categoryId)
    {
        return $this->setData(CatalogInterface::CATEGORY_ID, $categoryId);
    }

    /**
     * Get CategoryName
     *
     * @return string|null
     */
    public function getCategoryName()
    {
        return $this->getData(CatalogInterface::CATEGORY_NAME);
    }

    /**
     * Set CategoryName
     *
     * @param string $categoryName
     * @return CatalogInterface
     */
    public function setCategoryName($categoryName)
    {
        return $this->setData(CatalogInterface::CATEGORY_NAME, $categoryName);
    }

    /**
     * Get EventType
     *
     * @return string|null
     */
    public function getEventType()
    {
        return $this->getData(CatalogInterface::EVENT_TYPE);
    }

    /**
     * Set EventType
     *
     * @param string $eventType
     * @return CatalogInterface
     */
    public function setEventType($eventType)
    {
        return $this->setData(CatalogInterface::EVENT_TYPE, $eventType);
    }

    /**
     * Get created at time
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(CatalogInterface::CREATED_AT);
    }

    /**
     * Set created at time
     *
     * @param string $createdAt
     * @return CatalogInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(CatalogInterface::CREATED_AT, $createdAt);
    }

    /**
     * Get updated at time
     *
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(CatalogInterface::UPDATED_AT);
    }

    /**
     * Set updated at time
     *
     * @param string $updatedAt
     * @return CatalogInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(CatalogInterface::UPDATED_AT, $updatedAt);
    }
}
