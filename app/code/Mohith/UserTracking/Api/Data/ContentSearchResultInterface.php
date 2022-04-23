<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 17/3/22
 * Time: 11:35 AM
 */

namespace Mohith\UserTracking\Api\Data;

/**
 * Interface ContentSearchResultInterface
 * @package Mohith\UserTracking\Api\Data
 */
interface ContentSearchResultInterface
{
    /**
     * Get Team list.
     *
     * @return ContentInterface[]
     */
    public function getItems();

    /**
     * Set Team list.
     *
     * @param ContentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}