<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 17/4/22
 * Time: 8:28 PM
 */

namespace Mohith\UserTracking\Controller\Adminhtml\Content;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Ui\Component\MassAction\Filter;
use Mohith\UserTracking\Api\ContentRepositoryInterface;
use Mohith\UserTracking\Model\ResourceModel\Content\CollectionFactory;
use Psr\Log\LoggerInterface;

/**
 * Class MassDelete
 * @package Mohith\UserTracking\Controller\Adminhtml\Content
 */
class MassDelete implements ActionInterface
{
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var Filter
     */
    private $filter;
    /**
     * @var ContentRepositoryInterface
     */
    private $contentRepositoryInterface;
    /**
     * @var ManagerInterface
     */
    private $messageManager;
    /**
     * @var RedirectFactory
     */
    private $resultRedirectFactory;

    /**
     * MassDelete constructor.
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     * @param ContentRepositoryInterface $contentRepositoryInterface
     * @param ManagerInterface $messageManager
     * @param RedirectFactory $resultRedirectFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Filter $filter,
        ContentRepositoryInterface $contentRepositoryInterface,
        ManagerInterface $messageManager,
        RedirectFactory $resultRedirectFactory,
        LoggerInterface $logger
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->filter = $filter;
        $this->contentRepositoryInterface = $contentRepositoryInterface;
        $this->messageManager = $messageManager;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->logger = $logger;
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();
            foreach ($collection->getItems() as $item) {
                $this->contentRepositoryInterface->deleteById($item->getContentId());
            }
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $collectionSize)
            );
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}