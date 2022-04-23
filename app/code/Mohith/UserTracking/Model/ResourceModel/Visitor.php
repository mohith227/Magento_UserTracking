<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 15/3/22
 * Time: 4:53 PM
 */

namespace Mohith\UserTracking\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class Visitor
 * @package Mohith\UserTracking\Model\ResourceModel
 */
class Visitor extends AbstractDb
{

    /**
     * Visitor constructor.
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
        $this->_init('mohith_visitor', 'entity_id');
    }
}