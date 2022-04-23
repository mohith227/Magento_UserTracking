<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 17/3/22
 * Time: 11:21 AM
 */

namespace Mohith\UserTracking\Api\Data;

/**
 * Interface ContentInterface
 * @package Mohith\UserTracking\Api\Data
 */
interface ContentInterface
{
    /**
     * Content ID
     *
     * @var int
     */
    const CONTENT_ID = 'content_id';
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
     * Page ID
     *
     * @var int
     */
    const PAGE_ID = 'page_id';
    /**
     * Page Identifier
     *
     * @var string
     */
    const PAGE_IDENTIFIER = 'page_identifier';
    /**
     * Page Name
     *
     * @var string
     */
    const PAGE_NAME = 'page_name';
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
     * Get ContentID
     *
     * @return int|null
     */
    public function getContentId();

    /**
     * Set ContentID
     *
     * @param int $contentId
     * @return ContentInterface
     */
    public function setCatalogId($contentId);

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
     * @return ContentInterface
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
     * @return ContentInterface
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
     * @return ContentInterface
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
     * @return ContentInterface
     */
    public function setCustomerGroup($customerGroup);

    /**
     * Get PageID
     *
     * @return int|null
     */
    public function getPageId();

    /**
     * Set PageID
     *
     * @param int $pageId
     * @return ContentInterface
     */
    public function setPageId($pageId);

    /**
     * Get PageIdentifier
     *
     * @return string|null
     */
    public function getPageIdentifier();

    /**
     * Set PageIdentifier
     *
     * @param string $pageIdentifier
     * @return ContentInterface
     */
    public function setPageIdentifier($pageIdentifier);

    /**
     * Get PageName
     *
     * @return string|null
     */
    public function getPageName();

    /**
     * Set PageName
     *
     * @param string $pageName
     * @return ContentInterface
     */
    public function setPageName($pageName);
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
     * @return ContentInterface
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
     * @return ContentInterface
     */
    public function setUpdatedAt($updatedAt);
}