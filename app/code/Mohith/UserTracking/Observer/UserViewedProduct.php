<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 15/4/22
 * Time: 5:09 PM
 */

namespace Mohith\UserTracking\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Mohith\UserTracking\Api\Data\CatalogInterfaceFactory;
use Mohith\UserTracking\Model\AddVisitorCatalog;
use Mohith\UserTracking\Model\Config\UserTrackingConfig;
use Psr\Log\LoggerInterface;

/**
 * Class UserViewedProduct
 * @package Mohith\UserTracking\Observer
 */
class UserViewedProduct implements ObserverInterface
{
    /**
     * @var UserTrackingConfig
     */
    private $userTrackingConfig;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var CatalogInterfaceFactory
     */
    private $catalogInterfaceFactory;
    /**
     * @var AddVisitorCatalog
     */
    private $addVisitorCatalog;

    /**
     * UserViewedProduct constructor.
     *
     * @param CatalogInterfaceFactory $catalogInterfaceFactory
     * @param AddVisitorCatalog $addVisitorCatalog
     * @param UserTrackingConfig $userTrackingConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        CatalogInterfaceFactory $catalogInterfaceFactory,
        AddVisitorCatalog $addVisitorCatalog,
        UserTrackingConfig $userTrackingConfig,
        LoggerInterface $logger
    )
    {
        $this->catalogInterfaceFactory = $catalogInterfaceFactory;
        $this->addVisitorCatalog = $addVisitorCatalog;
        $this->userTrackingConfig = $userTrackingConfig;
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        try {
            if ($this->userTrackingConfig->getIsActive()) {
                $product = $observer->getProduct();
                if ($product) {
                    $visitorCatalog = $this->catalogInterfaceFactory->create();
                    $visitorCatalog->setProductId($product->getId());
                    $visitorCatalog->setProductSku($product->getSku());
                    $visitorCatalog->setEventType("Product Page");
                    $this->addVisitorCatalog->addVisitorCatalog($visitorCatalog);
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}
