<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 17/3/22
 * Time: 3:41 PM
 */

namespace Mohith\UserTracking\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class Content
 * @package Mohith\UserTracking\Model\ResourceModel
 */
class Content extends AbstractDb
{
    /**
     * Content constructor.
     * @param Context $context
     * @param null $connectionName
     */
    public function __construct(
        Context $context,
        $connectionName = null
    )
    {
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mohith_content_user_experience', 'content_id');
    }
}