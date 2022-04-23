<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 15/3/22
 * Time: 3:30 PM
 */

namespace Mohith\UserTracking\Api\Data;

/**
 * Interface VisitorSearchResultInterface
 * @package Mohith\UserTracking\Api\Data
 */
interface VisitorSearchResultInterface
{
    /**
     * Get Team list.
     *
     * @return VisitorInterface[]
     */
    public function getItems();

    /**
     * Set Team list.
     *
     * @param VisitorInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
