<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 15/4/22
 * Time: 9:59 PM
 */

namespace Mohith\UserTracking\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Model\SessionFactory as CustomerSessionFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Mohith\UserTracking\Api\CatalogRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AddVisitorCatalog
 * @package Mohith\UserTracking\Model
 */
class AddVisitorCatalog
{
    /**
     * @var SessionManagerInterface
     */
    private $sessionManagerInterface;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepositoryInterface;
    /**
     * @var CustomerSessionFactory
     */
    private $customerSessionFactory;
    /**
     * @var GroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * @var CatalogRepositoryInterface
     */
    private $catalogRepositoryInterface;

    /**
     * AddVisitorCatalog constructor.
     *
     * @param SessionManagerInterface $sessionManagerInterface
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     * @param GroupRepositoryInterface $groupRepository
     * @param CustomerSessionFactory $customerSessionFactory
     * @param CatalogRepositoryInterface $catalogRepositoryInterface
     * @param LoggerInterface $logger
     */
    public function __construct(
        SessionManagerInterface $sessionManagerInterface,
        CustomerRepositoryInterface $customerRepositoryInterface,
        GroupRepositoryInterface $groupRepository,
        CustomerSessionFactory $customerSessionFactory,
        CatalogRepositoryInterface $catalogRepositoryInterface,
        LoggerInterface $logger
    )
    {
        $this->sessionManagerInterface = $sessionManagerInterface;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->groupRepository = $groupRepository;
        $this->customerSessionFactory = $customerSessionFactory;
        $this->catalogRepositoryInterface = $catalogRepositoryInterface;
        $this->logger = $logger;
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomerData()
    {
        try {
            $customerSession = $this->customerSessionFactory->create();
            if ($customerSession->isLoggedIn()) {
                return $this->customerRepositoryInterface->getById($customerSession->getCustomerId());
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Get Group Name
     *
     * @param $groupId
     * @return string
     */
    public function getGroupName($groupId)
    {
        try {
            $group = $this->groupRepository->getById($groupId);
            return $group->getCode();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * @param $visitorCatalog
     */
    public function addVisitorCatalog($visitorCatalog)
    {
        try {
            $customerData = $this->getCustomerData();
            if (isset($customerData)) {
                $visitorCatalog->setCustomerId($customerData->getId());
                $visitorCatalog->setCustomerEmail($customerData->getEmail());
                $visitorCatalog->setCustomerGroup($this->getGroupName($customerData->getGroupId()));
                $visitorCatalog->setVisitorId("NA");
            } else {
                $visitorId = $this->sessionManagerInterface->getVisitorId();
                $visitorCatalog->setVisitorId($visitorId);
                $visitorCatalog->setCustomerGroup("Guest");
                $visitorCatalog->setCustomerId("NA");
                $visitorCatalog->setCustomerEmail("NA");
            }
            if (isset($customerData) || isset($visitorId)) {
                $this->catalogRepositoryInterface->save($visitorCatalog);
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}
