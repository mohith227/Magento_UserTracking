<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 16/3/22
 * Time: 4:28 PM
 */

namespace Mohith\UserTracking\Model\ResourceModel\Catalog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Mohith\UserTracking\Model\Catalog as CatalogModel;
use Mohith\UserTracking\Model\ResourceModel\Catalog as CatalogResourceModel;

/**
 * Class Collection
 * @package Mohith\UserTracking\Model\ResourceModel\Catalog
 */
class Collection extends AbstractCollection
{
    /**
     * ID Field name
     *
     * @var string
     */
    protected $_idFieldName = 'catalog_id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'mohith_catalog_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'visitor_catalog';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            CatalogModel::class,
            CatalogResourceModel::class
        );
    }
}