<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 17/3/22
 * Time: 3:25 PM
 */

namespace Mohith\UserTracking\Model;

use Magento\Framework\Model\AbstractModel;
use Mohith\UserTracking\Api\Data\ContentInterface;
use Mohith\UserTracking\Model\ResourceModel\Content as ContentModel;

/**
 * Class Content
 * @package Mohith\UserTracking\Model
 */
class Content extends AbstractModel implements ContentInterface
{
    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'mohith_content';

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
    protected $_eventPrefix = 'mohith_content';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'content';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ContentModel::class);
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
     * Get ContentID
     *
     * @return int|null
     */
    public function getContentId()
    {
        return $this->getData(ContentInterface::CONTENT_ID);
    }

    /**
     * Set ContentID
     *
     * @param int $contentId
     * @return ContentInterface
     */
    public function setCatalogId($contentId)
    {
        return $this->setData(ContentInterface::CONTENT_ID, $contentId);
    }

    /**
     * Get VisitorID
     *
     * @return int|null
     */
    public function getVisitorId()
    {
        return $this->getData(ContentInterface::VISITOR_ID);
    }

    /**
     * Set VisitorID
     *
     * @param int $visitorId
     * @return ContentInterface
     */
    public function setVisitorId($visitorId)
    {
        return $this->setData(ContentInterface::VISITOR_ID, $visitorId);
    }

    /**
     * Get CustomerID
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->getData(ContentInterface::CUSTOMER_ID);
    }

    /**
     * Set CustomerID
     *
     * @param int $customerId
     * @return ContentInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(ContentInterface::CUSTOMER_ID, $customerId);
    }

    /**
     * Get CustomerEmail
     *
     * @return string|null
     */
    public function getCustomerEmail()
    {
        return $this->getData(ContentInterface::CUSTOMER_EMAIL);
    }

    /**
     * Set CustomerEmail
     *
     * @param string $customerEmail
     * @return ContentInterface
     */
    public function setCustomerEmail($customerEmail)
    {
        return $this->setData(ContentInterface::CUSTOMER_EMAIL, $customerEmail);
    }

    /**
     * Get CustomerGroup
     *
     * @return string|null
     */
    public function getCustomerGroup()
    {
        return $this->getData(ContentInterface::CUSTOMER_GROUP);
    }

    /**
     * Set CustomerGroup
     *
     * @param string $customerGroup
     * @return ContentInterface
     */
    public function setCustomerGroup($customerGroup)
    {
        return $this->setData(ContentInterface::CUSTOMER_GROUP, $customerGroup);
    }

    /**
     * Get PageID
     *
     * @return int|null
     */
    public function getPageId()
    {
        return $this->getData(ContentInterface::PAGE_ID);
    }

    /**
     * Set PageID
     *
     * @param int $pageId
     * @return ContentInterface
     */
    public function setPageId($pageId)
    {
        return $this->setData(ContentInterface::PAGE_ID, $pageId);
    }

    /**
     * Get PageIdentifier
     *
     * @return string|null
     */
    public function getPageIdentifier()
    {
        return $this->getData(ContentInterface::PAGE_IDENTIFIER);
    }

    /**
     * Set PageIdentifier
     *
     * @param string $pageIdentifier
     * @return ContentInterface
     */
    public function setPageIdentifier($pageIdentifier)
    {
        return $this->setData(ContentInterface::PAGE_IDENTIFIER, $pageIdentifier);
    }

    /**
     * Get PageName
     *
     * @return string|null
     */
    public function getPageName()
    {
        return $this->getData(ContentInterface::PAGE_NAME);
    }

    /**
     * Set PageName
     *
     * @param string $pageName
     * @return ContentInterface
     */
    public function setPageName($pageName)
    {
        return $this->setData(ContentInterface::PAGE_NAME, $pageName);
    }

    /**
     * Get created at time
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(ContentInterface::CREATED_AT);
    }

    /**
     * Set created at time
     *
     * @param string $createdAt
     * @return ContentInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(ContentInterface::CREATED_AT, $createdAt);
    }

    /**
     * Get updated at time
     *
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(ContentInterface::UPDATED_AT);
    }

    /**
     * Set updated at time
     *
     * @param string $updatedAt
     * @return ContentInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(ContentInterface::UPDATED_AT, $updatedAt);
    }
}
