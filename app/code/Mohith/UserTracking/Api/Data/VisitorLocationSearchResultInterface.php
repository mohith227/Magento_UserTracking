<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 2/4/22
 * Time: 12:43 PM
 */

namespace Mohith\UserTracking\Api\Data;

/**
 * Interface VisitorLocationSearchResultInterface
 * @package Mohith\UserTracking\Api\Data
 */
interface VisitorLocationSearchResultInterface
{
    /**
     * Get Item list.
     *
     * @return VisitorLocationInterface[]
     */
    public function getItems();

    /**
     * Set Item list.
     *
     * @param VisitorLocationInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}