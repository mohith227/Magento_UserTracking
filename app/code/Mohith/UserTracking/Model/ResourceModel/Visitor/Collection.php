<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 15/3/22
 * Time: 5:08 PM
 */

namespace Mohith\UserTracking\Model\ResourceModel\Visitor;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Mohith\UserTracking\Model\ResourceModel\Visitor as VisitorResourceModel;
use Mohith\UserTracking\Model\Visitor as VisitorModel;

/**
 * Class Collection
 * @package Mohith\UserTracking\Model\ResourceModel\Visitor
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
    protected $_eventPrefix = 'mohith_visitor_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'visitor_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            VisitorModel::class,
            VisitorResourceModel::class
        );
    }
}
