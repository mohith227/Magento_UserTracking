<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 15/4/22
 * Time: 11:35 PM
 */

namespace Mohith\UserTracking\Observer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Model\SessionFactory as CustomerSessionFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Session\SessionManagerInterface;
use Mohith\UserTracking\Api\ContentRepositoryInterface;
use Mohith\UserTracking\Api\Data\ContentInterfaceFactory;
use Mohith\UserTracking\Model\Config\UserTrackingConfig;
use Psr\Log\LoggerInterface;

/**
 * Class UserViewedCmsPage
 * @package Mohith\UserTracking\Observer
 */
class UserViewedCmsPage implements ObserverInterface
{
    /**
     * @var UserTrackingConfig
     */
    private $userTrackingConfig;
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
     * @var ContentInterfaceFactory
     */
    private $contentInterfaceFactory;
    /**
     * @var ContentRepositoryInterface
     */
    private $contentRepositoryInterface;

    /**
     * AddVisitorCatalog constructor.
     *
     * @param SessionManagerInterface $sessionManagerInterface
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     * @param GroupRepositoryInterface $groupRepository
     * @param CustomerSessionFactory $customerSessionFactory
     * @param ContentInterfaceFactory $contentInterfaceFactory
     * @param ContentRepositoryInterface $contentRepositoryInterface
     * @param UserTrackingConfig $userTrackingConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        SessionManagerInterface $sessionManagerInterface,
        CustomerRepositoryInterface $customerRepositoryInterface,
        GroupRepositoryInterface $groupRepository,
        CustomerSessionFactory $customerSessionFactory,
        ContentInterfaceFactory $contentInterfaceFactory,
        ContentRepositoryInterface $contentRepositoryInterface,
        UserTrackingConfig $userTrackingConfig,
        LoggerInterface $logger
    )
    {
        $this->sessionManagerInterface = $sessionManagerInterface;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->groupRepository = $groupRepository;
        $this->customerSessionFactory = $customerSessionFactory;
        $this->contentInterfaceFactory = $contentInterfaceFactory;
        $this->contentRepositoryInterface = $contentRepositoryInterface;
        $this->userTrackingConfig = $userTrackingConfig;
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
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {

        try {
            if ($this->userTrackingConfig->getIsActive()) {
                $page = $observer->getEvent()->getPage();
                if ($page) {
                    $visitorContent = $this->contentInterfaceFactory->create();
                    $visitorContent->setPageId($page->getId());
                    $visitorContent->setPageName($page->getTitle());
                    $visitorContent->setPageIdentifier($page->getIdentifier());
                    $customerData = $this->getCustomerData();
                    if (isset($customerData)) {
                        $customerId = $customerData->getId();
                        $visitorContent->setCustomerId($customerId);
                        $visitorContent->setCustomerEmail($customerData->getEmail());
                        $visitorContent->setCustomerGroup($this->getGroupName($customerData->getGroupId()));
                    } else {
                        $visitorId = $this->sessionManagerInterface->getVisitorId();
                        $visitorContent->setVisitorId($visitorId);
                        $visitorContent->setCustomerGroup("Guest");
                    }
                    if (isset($customerId) || isset($visitorId)) {
                        $this->contentRepositoryInterface->save($visitorContent);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}
