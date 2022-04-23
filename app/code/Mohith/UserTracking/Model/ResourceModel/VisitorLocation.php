<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 2/4/22
 * Time: 1:12 PM
 */

namespace Mohith\UserTracking\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class VisitorLocation
 * @package Mohith\UserTracking\Model\ResourceModel
 */
class VisitorLocation extends AbstractDb
{
    /**
     * VisitorLocation constructor.
     * @param Context $context
     * @param null $connectionName
     */
    public function __construct(
        Context $context,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mohith_visitor_location', 'entity_id');
    }
}