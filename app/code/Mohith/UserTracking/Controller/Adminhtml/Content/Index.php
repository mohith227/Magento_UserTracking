<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 17/4/22
 * Time: 8:27 PM
 */

namespace Mohith\UserTracking\Controller\Adminhtml\Content;

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
        $resultPage->getConfig()->getTitle()->prepend((__('User Viewed Content Pages')));
        return $resultPage;
    }
}