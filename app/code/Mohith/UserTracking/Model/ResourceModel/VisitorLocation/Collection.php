<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 2/4/22
 * Time: 1:14 PM
 */

namespace Mohith\UserTracking\Model\ResourceModel\VisitorLocation;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Mohith\UserTracking\Model\ResourceModel\VisitorLocation as VisitorLocationResourceModel;
use Mohith\UserTracking\Model\VisitorLocation as VisitorLocationModel;

/**
 * Class Collection
 * @package Mohith\UserTracking\Model\ResourceModel\VisitorLocation
 */
class Collection extends AbstractCollection
{
    /**
     * ID Field name
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'mohith_visitor_location_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'visitor_location_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            VisitorLocationModel::class,
            VisitorLocationResourceModel::class
        );
    }
}
