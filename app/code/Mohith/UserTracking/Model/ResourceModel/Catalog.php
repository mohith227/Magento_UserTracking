<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 16/3/22
 * Time: 4:26 PM
 */

namespace Mohith\UserTracking\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class Catalog
 * @package Mohith\UserTracking\Model\ResourceModel
 */
class Catalog extends AbstractDb
{
    /**
     * Catalog constructor.
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
        $this->_init('mohith_catalog_user_experience', 'catalog_id');
    }
}