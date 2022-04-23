<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 17/4/22
 * Time: 8:46 PM
 */

namespace Mohith\UserTracking\Controller\Adminhtml\Location;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Mohith\UserTracking\Controller\Adminhtml\Content
 */
class Index implements ActionInterface
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Index constructor.
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Visitor Details')));
        return $resultPage;
    }
}