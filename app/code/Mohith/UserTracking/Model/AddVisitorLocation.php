<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 9/4/22
 * Time: 5:06 PM
 */

namespace Mohith\UserTracking\Model;

use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\HTTP\Client\Curl;
use Mohith\UserTracking\Api\Data\VisitorLocationInterfaceFactory;
use Mohith\UserTracking\Api\VisitorLocationRepositoryInterface;
use Mohith\UserTracking\Model\Config\UserTrackingConfig;
use Psr\Log\LoggerInterface;

/**
 * Class AddVisitorLocation
 * @package Mohith\UserTracking\Model
 */
class AddVisitorLocation
{
    /**
     * @var Curl
     */
    private $curl;
    /**
     * @var UserTrackingConfig
     */
    private $userTrackingConfig;
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var VisitorLocationInterfaceFactory
     */
    private $visitorLocationInterfaceFactory;
    /**
     * @var VisitorLocationRepositoryInterface
     */
    private $visitorLocationRepositoryInterface;
    /**
     * @var GroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * AddVisitorLocation constructor.
     * @param Curl $curl
     * @param GroupRepositoryInterface $groupRepository
     * @param UserTrackingConfig $userTrackingConfig
     * @param VisitorLocationInterfaceFactory $visitorLocationInterfaceFactory
     * @param VisitorLocationRepositoryInterface $visitorLocationRepositoryInterface
     * @param LoggerInterface $logger
     */
    public function __construct(
        Curl $curl,
        GroupRepositoryInterface $groupRepository,
        UserTrackingConfig $userTrackingConfig,
        VisitorLocationInterfaceFactory $visitorLocationInterfaceFactory,
        VisitorLocationRepositoryInterface $visitorLocationRepositoryInterface,
        LoggerInterface $logger
    )
    {
        $this->curl = $curl;
        $this->groupRepository = $groupRepository;
        $this->userTrackingConfig = $userTrackingConfig;
        $this->visitorLocationInterfaceFactory = $visitorLocationInterfaceFactory;
        $this->visitorLocationRepositoryInterface = $visitorLocationRepositoryInterface;
        $this->logger = $logger;
    }

    /**
     * Get Visitor Details Based on IP
     *
     * @param $userIP
     * @return mixed
     */
    public function getVisitorDetailsBasedOnIp($userIP)
    {
        try {
            $getFreeGeoIpURL = $this->userTrackingConfig->getFreeGeoIpURL();
            $getFreeGeoIpKey = $this->userTrackingConfig->getFreeGeoIpApiKey();
            $url = $getFreeGeoIpURL . $userIP . "?apikey=" . $getFreeGeoIpKey;
            $this->curl->get($url);
            return json_decode($this->curl->getBody(), true);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Returns the Platform of the user
     *
     * @param $userAgent
     * @return string
     */
    public function getPlatform($userAgent)
    {
        $platform = 'Unknown';
        if (preg_match('/linux/i', $userAgent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $userAgent)) {
            $platform = 'windows';
        }
        return $platform;
    }

    /**
     * Provides BrowserName and version
     *
     * @param $userAgent
     * @return string
     */
    public function getBrowserNameAndVersion($userAgent)
    {
        $browserName = 'Unknown';
        $version = "";
        if (preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent)) {
            $browserName = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browserName = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            $browserName = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browserName = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browserName = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $userAgent)) {
            $browserName = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = ['Version', $ub, 'other'];
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $userAgent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($userAgent, "Version") < strripos($userAgent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }
        return $browserName . " " . "version" . " " . $version;
    }

    /**
     * Get BrowserDetails
     *
     * @return string
     */
    public function getBrowserDetails()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $platform = $this->getPlatform($userAgent);
        $browserDetails = $this->getBrowserNameAndVersion($userAgent);
        return $browserDetails . " " . "on" . " " . $platform . " " . "platform";
    }

    /**
     * Add Guest Details
     *
     * @param $visitorId
     * @param $visitorDetails
     */
    public function addGuestDetails($visitorId, $visitorDetails)
    {
        try {
            $visitorData = $this->visitorLocationRepositoryInterface->getByVisitorId($visitorId);
            if (!isset($visitorData) || $visitorData->getBrowserOs() != $this->getBrowserDetails()) {
                $visitorLocation = $this->visitorLocationInterfaceFactory->create();
                $visitorLocation->setVisitorId($visitorId);
                $visitorLocation->setCustomerGroup("Guest");
                $this->addVisitorDetails($visitorLocation, $visitorDetails);
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
     * Add Customer Details
     *
     * @param $customer
     * @param $visitorDetails
     */
    public function addCustomerDetails($customer, $visitorDetails)
    {
        try {
            $customerData = $this->visitorLocationRepositoryInterface->getByCustomerId($customer->getId());
            if (!isset($customerData) || $customerData->getBrowserOs() != $this->getBrowserDetails()) {
                $visitorLocation = $this->visitorLocationInterfaceFactory->create();
                $visitorLocation->setCustomerId($customer->getId());
                $visitorLocation->setCustomerEmail($customer->getEmail());
                $groupName = $this->getGroupName($customer->GetGroupId());
                $visitorLocation->setCustomerGroup($groupName);
                $this->addVisitorDetails($visitorLocation, $visitorDetails);
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Add Visitor Details
     *
     * @param $visitorLocation
     * @param $visitorDetails
     */
    public function addVisitorDetails($visitorLocation, $visitorDetails)
    {
        try {
            $ip_address = isset($visitorDetails['ip']) ? $visitorDetails['ip'] : '';
            $country_name = isset($visitorDetails['country_name']) ? $visitorDetails['country_name'] : '';
            $country_code = isset($visitorDetails['country_code']) ? $visitorDetails['country_code'] : '';
            $region_name = isset($visitorDetails['region_name']) ? $visitorDetails['region_name'] : '';
            $region_code = isset($visitorDetails['region_code']) ? $visitorDetails['region_code'] : '';
            $city = isset($visitorDetails['city']) ? $visitorDetails['city'] : '';
            $zip_code = isset($visitorDetails['zip_code']) ? $visitorDetails['zip_code'] : '';
            $time_zone = isset($visitorDetails['time_zone']) ? $visitorDetails['time_zone'] : '';
            $visitorLocation->setIpAddress($ip_address);
            $visitorLocation->setCountryName($country_name);
            $visitorLocation->setCountryCode($country_code);
            $visitorLocation->setRegionName($region_name);
            $visitorLocation->setRegionCode($region_code);
            $visitorLocation->setCity($city);
            $visitorLocation->setZipCode($zip_code);
            $visitorLocation->setTimeZone($time_zone);
            $visitorLocation->setBrowserOs($this->getBrowserDetails());
            $this->visitorLocationRepositoryInterface->save($visitorLocation);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}
