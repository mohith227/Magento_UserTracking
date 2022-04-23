<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 2/4/22
 * Time: 11:43 PM
 */

namespace Mohith\UserTracking\Block;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\SessionFactory as CustomerSessionFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Element\Template;
use Mohith\UserTracking\Model\AddVisitor;
use Mohith\UserTracking\Model\AddVisitorLocation;
use Mohith\UserTracking\Model\Config\UserTrackingConfig;
use Psr\Log\LoggerInterface;

/**
 * Class UserTracking
 * @package Mohith\UserTracking\Block
 */
class UserTracking extends Template
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
     * @var AddVisitor
     */
    private $addVisitor;
    /**
     * @var CustomerSessionFactory
     */
    private $customerSessionFactory;
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var AddVisitorLocation
     */
    private $addVisitorLocation;
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepositoryInterface;

    /**
     * UserTracking constructor.
     * @param Template\Context $context
     * @param SessionManagerInterface $sessionManagerInterface
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     * @param CustomerSessionFactory $customerSessionFactory
     * @param AddVisitor $addVisitor
     * @param AddVisitorLocation $addVisitorLocation
     * @param UserTrackingConfig $userTrackingConfig
     * @param LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        SessionManagerInterface $sessionManagerInterface,
        CustomerRepositoryInterface $customerRepositoryInterface,
        CustomerSessionFactory $customerSessionFactory,
        AddVisitor $addVisitor,
        AddVisitorLocation $addVisitorLocation,
        UserTrackingConfig $userTrackingConfig,
        LoggerInterface $logger,
        array $data = []
    )
    {
        $this->sessionManagerInterface = $sessionManagerInterface;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->customerSessionFactory = $customerSessionFactory;
        $this->addVisitor = $addVisitor;
        $this->addVisitorLocation = $addVisitorLocation;
        $this->userTrackingConfig = $userTrackingConfig;
        $this->logger = $logger;
        parent::__construct($context, $data);
    }

    /**
     * Provides Customer Data
     *
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
     * get UserIP
     *
     * @return mixed
     */
    public function getUserIp()
    {
        //whether ip is from share internet
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } //whether ip is from remote address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }

    /**
     * Set Visitor Id
     */
    public function setVisitorId()
    {
        if ($this->userTrackingConfig->getIsActive()) {
            $sessionVisitorId = $this->sessionManagerInterface->getVisitorId();
            if (!isset($sessionVisitorId)) {
                $userIP = $this->getUserIp();
                $visitorId = $this->addVisitor->getVisitorId($userIP);
                $visitorDetails = $this->addVisitor->getVisitorDetailsBasedOnIp($userIP);
                $this->sessionManagerInterface->setVisitorId($visitorId);
                $customerData = $this->getCustomerData();
                if (isset($customerData)) {
                    $this->addVisitorLocation->addCustomerDetails($customerData, $visitorDetails);
                } else {
                    $this->addVisitorLocation->addGuestDetails($visitorId, $visitorDetails);
                }
            }
        }
    }
}
