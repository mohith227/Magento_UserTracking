<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 9/4/22
 * Time: 8:52 AM
 */

namespace Mohith\UserTracking\Model;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Session\SessionManagerInterface;
use Mohith\UserTracking\Api\Data\VisitorInterfaceFactory;
use Mohith\UserTracking\Api\VisitorRepositoryInterface;
use Mohith\UserTracking\Model\Config\UserTrackingConfig;
use Mohith\UserTracking\Model\ResourceModel\Visitor\CollectionFactory as VisitorCollectionFactory;
use Psr\Log\LoggerInterface;

/**
 * Class AddVisitor
 * @package Mohith\UserTracking\Model
 */
class AddVisitor
{
    /**
     * @var UserTrackingConfig
     */
    private $userTrackingConfig;
    /**
     * @var Curl
     */
    private $curl;
    /**
     * @var VisitorInterfaceFactory
     */
    private $visitorInterfaceFactory;
    /**
     * @var VisitorRepositoryInterface
     */
    private $visitorRepository;

    /**
     * @var SessionManagerInterface
     */
    private $sessionManagerInterface;
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var VisitorColectionFactory
     */
    private $visitorCollectionFactory;

    /**
     * AddVisitor constructor.
     * @param SessionManagerInterface $sessionManagerInterface
     * @param Curl $curl
     * @param VisitorInterfaceFactory $visitorInterfaceFactory
     * @param VisitorRepositoryInterface $visitorRepository
     * @param UserTrackingConfig $userTrackingConfig
     * @param VisitorCollectionFactory $visitorCollectionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        SessionManagerInterface $sessionManagerInterface,
        Curl $curl,
        VisitorInterfaceFactory $visitorInterfaceFactory,
        VisitorRepositoryInterface $visitorRepository,
        UserTrackingConfig $userTrackingConfig,
        VisitorCollectionFactory $visitorCollectionFactory,
        LoggerInterface $logger
    )
    {
        $this->sessionManagerInterface = $sessionManagerInterface;
        $this->curl = $curl;
        $this->visitorInterfaceFactory = $visitorInterfaceFactory;
        $this->visitorRepository = $visitorRepository;
        $this->userTrackingConfig = $userTrackingConfig;
        $this->visitorCollectionFactory = $visitorCollectionFactory;
        $this->logger = $logger;
    }

    /**
     * Provides Details based on IP
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
     * Creates New visitor
     *
     * @param $response
     * @param $userIP
     * @param $sessionId
     * @return int|null
     */
    public function createVisitor($response, $userIP, $sessionId)
    {
        try {
            $visitorCollection = $this->visitorCollectionFactory->create();
            $visitor = $this->visitorInterfaceFactory->create();
            if ($visitorCollection) {
                $lastVisitorId = $visitorCollection->setOrder('visitor_id', 'desc')
                    ->getFirstItem()->getVisitorId();
                $visitor->setVisitorId($lastVisitorId + 1);
            }
            $latitude = isset($response['latitude']) ? $response['latitude'] : '';
            $longitude = isset($response['longitude']) ? $response['longitude'] : '';
            $visitor->setIpAddress($userIP);
            $visitor->setLatitude($latitude);
            $visitor->setLongitude($longitude);
            $visitor->setSessionId($sessionId);
            $visitor = $this->visitorRepository->save($visitor);
            return $visitor->getVisitorId();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Adds Existing Visitor details
     *
     * @param $response
     * @param $userIP
     * @param $sessionId
     * @param $visitorId
     * @return int|null
     */
    public function updateVisitor($response, $userIP, $sessionId, $visitorId)
    {
        try {
            $latitude = isset($response['latitude']) ? $response['latitude'] : '';
            $longitude = isset($response['longitude']) ? $response['longitude'] : '';
            $visitor = $this->visitorInterfaceFactory->create();
            $visitor->setIpAddress($userIP);
            $visitor->setLatitude($latitude);
            $visitor->setLongitude($longitude);
            $visitor->setSessionId($sessionId);
            $visitor->setVisitorId($visitorId);
            $visitor = $this->visitorRepository->save($visitor);
            return $visitor->getVisitorId();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Check the Existing visitors based on sessionId and IP
     *
     * @param $sessionId
     * @param $userIP
     * @return int|null
     */
    public function isExistingVisitor($sessionId, $userIP)
    {
        try {
            $visitorData = $this->visitorRepository->getBySessionId($sessionId);
            if (isset($visitorData)) {
                if ($visitorData->getIpAddress() != $userIP) {
                    $response = $this->getVisitorDetailsBasedOnIp($userIP);
                    $this->updateVisitor($response, $userIP, $sessionId, $visitorData->getVisitorId());
                }
                return $visitorData->getVisitorId();
            }
            $visitorData = $this->visitorRepository->getByIP($userIP);
            if (isset($visitorData)) {
                if ($visitorData->getSessionId() != $sessionId) {
                    $response = $this->getVisitorDetailsBasedOnIp($userIP);
                    $this->updateVisitor($response, $userIP, $sessionId, $visitorData->getVisitorId());
                }
                return $visitorData->getVisitorId();
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Provides the Visitor Id
     *
     * @param $userIP
     * @return int|null
     */
    public function getVisitorId($userIP)
    {
        try {
            $sessionId = $this->sessionManagerInterface->getSessionId();
            $visitorId = $this->isExistingVisitor($sessionId, $userIP);
            if (!isset($visitorId)) {
                $response = $this->getVisitorDetailsBasedOnIp($userIP);
                if (isset($response)) {
                    $latitude = isset($response['latitude']) ? $response['latitude'] : '';
                    $longitude = isset($response['longitude']) ? $response['longitude'] : '';
                    $vistiorData = $this->visitorRepository->getByLatitude($latitude);
                    if (isset($vistiorData) && $vistiorData->getLongitude() == $longitude) {
                        $this->updateVisitor($response, $userIP, $sessionId, $vistiorData->getVisitorId());
                        return $vistiorData->getVisitorId();
                    }
                    return $this->createVisitor($response, $userIP, $sessionId);
                }
            }
            return $visitorId;
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}
