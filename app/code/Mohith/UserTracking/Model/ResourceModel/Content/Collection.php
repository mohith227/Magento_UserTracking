<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 17/3/22
 * Time: 3:42 PM
 */

namespace Mohith\UserTracking\Model\ResourceModel\Content;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Mohith\UserTracking\Model\Content as ContentModel;
use Mohith\UserTracking\Model\ResourceModel\Content as ContentResourceModel;

/**
 * Class Collection
 * @package Mohith\UserTracking\Model\ResourceModel\Content
 */
class Collection extends AbstractCollection
{
    /**
     * ID Field name
     *
     * @var string
     */
    protected $_idFieldName = 'content_id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'mohith_content_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'visitor_content';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            ContentModel::class,
            ContentResourceModel::class
        );
    }
}