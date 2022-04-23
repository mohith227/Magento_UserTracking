<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 16/3/22
 * Time: 3:35 PM
 */

namespace Mohith\UserTracking\Api\Data;

/**
 * Interface CatalogSearchResultInterface
 * @package Mohith\UserTracking\Api\Data
 */
interface CatalogSearchResultInterface
{
    /**
     * Get Item list.
     *
     * @return CatalogInterface[]
     */
    public function getItems();

    /**
     * Set Item list.
     *
     * @param CatalogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}