<?php

namespace Dpd;

use SoapClient;
use SoapFault;
use Dpd\Business\Authentication;
use Dpd\Business\AuthenticationFault;
use Dpd\Business\ContentItem;
use Dpd\Business\ContentLine;
use Dpd\Business\Credentials;
use Dpd\Business\FaultCodeType;
use Dpd\Business\GetTrackingData;
use Dpd\Business\GetTrackingDataResponse;
use Dpd\Business\Login;
use Dpd\Business\OutputType;
use Dpd\Business\ParcelInformationType;
use Dpd\Business\ShipmentInfo;
use Dpd\Business\ShipmentResponse;
use Dpd\Business\StatusInfo;
use Dpd\Business\StoreOrders;
use Dpd\Business\StoreOrdersResponseType;
use Dpd\Business\TrackingResult;

class Api
{
    const DEV_ENVIRONMENT   = 0;
    const PROD_ENVIRONMENT  = 1;

    /** @var Api */
    private static Api $instance;
    /** @var int */
    private static int $environment = self::DEV_ENVIRONMENT;
    /** @var string[]  */
    private array $endpoint = [
        self::DEV_ENVIRONMENT => 'https://public-ws-stage.dpd.com/',
        self::PROD_ENVIRONMENT => 'https://public-ws.dpd.com/'
    ];

    /**
     * @return Api
     */
    public static function me(): Api
    {
        if (!isset(self::$instance)) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    /**
     * Set API environment to development version
     */
    public static function dev(): void
    {
        self::$environment = self::DEV_ENVIRONMENT;
    }

    /**
     * Set API environment to production version
     */
    public static function prod(): void
    {
        self::$environment = self::PROD_ENVIRONMENT;
    }

    /**
     * @param Credentials $credentials
     * @return bool|Login|AuthenticationFault
     * @throws SoapFault
     */
    public function auth(Credentials $credentials): bool|Login|AuthenticationFault
    {
        $client = new SoapClient(
            $this->getEndpoint() . 'services/LoginService/V2_0/?wsdl',
            [
                'trace' => true,
                'classmap' => [ 'Login' => Login::class ]
            ]
        );
        $client->__setLocation($this->getEndpoint() . 'services/LoginService/V2_0/');

        try {
            $response = $client->getAuth($credentials);
        } catch (SoapFault $exception) {
            return $this->processException($exception);
        }

        return
            is_object($response)
            && ($response->return ?? null) instanceof Login
                ? $response->return : false;
    }

    /**
     * @param Authentication $authentication
     * @param StoreOrders $storeOrders
     * @return AuthenticationFault|StoreOrdersResponseType|false
     * @throws SoapFault
     */
    public function storeOrders(Authentication $authentication, StoreOrders $storeOrders): bool|StoreOrdersResponseType|AuthenticationFault
    {
        $client = new SoapClient(
            $this->getEndpoint() . 'services/ShipmentService/V4_4/?wsdl',
            [
                'trace' => true,
                'classmap' => [
                    'storeOrdersResponseType' => StoreOrdersResponseType::class,
                    'OutputType' => OutputType::class,
                    'shipmentResponse' => ShipmentResponse::class,
                    'parcelInformationType' => ParcelInformationType::class,
                    'faultCodeType' => FaultCodeType::class
                ]
            ]
        );
        $client->__setSoapHeaders(
            new \SoapHeader(
                'http://dpd.com/common/service/types/Authentication/2.0',
                'authentication',
                $authentication
            )
        );
        $client->__setLocation($this->getEndpoint() . 'services/ShipmentService/V4_4/');

        try {
            $response = $client->storeOrders($storeOrders);
        } catch (SoapFault $exception) {
            return $this->processException($exception);
        }

        return
            is_object($response)
            && ($response->orderResult ?? null) instanceof StoreOrdersResponseType
                ? $response->orderResult : false;
    }

    /**
     * @param Authentication $authentication
     * @param GetTrackingData $trackingData
     * @return AuthenticationFault|GetTrackingDataResponse|false
     * @throws SoapFault
     */
    public function getTrackingData(Authentication $authentication, GetTrackingData $trackingData): bool|TrackingResult|AuthenticationFault
    {
        $client = new SoapClient(
            $this->getEndpoint() . 'services/ParcelLifeCycleService/V2_0/?wsdl',
            [
                'trace' => true,
                'classmap' => [
                    'TrackingResult' => TrackingResult::class,
                    'ShipmentInfo' => ShipmentInfo::class,
                    'StatusInfo' => StatusInfo::class,
                    'ContentItem' => ContentItem::class,
                    'ContentLine' => ContentLine::class,
                ]
            ]
        );
        $client->__setSoapHeaders(
            new \SoapHeader(
                'http://dpd.com/common/service/types/Authentication/2.0',
                'authentication',
                $authentication
            )
        );
        $client->__setLocation($this->getEndpoint() . 'services/ParcelLifeCycleService/V2_0/');

        try {
            $response = $client->getTrackingData($trackingData);
        } catch (SoapFault $exception) {
            return $this->processException($exception);
        }

        return
            is_object($response)
            && ($response->trackingresult ?? null) instanceof TrackingResult
                ? $response->trackingresult : false;
    }

    /** Disabled Api constructor. Use API::me() as singleton */
    protected function __construct() { }

    /**
     * @param SoapFault $exception
     * @return AuthenticationFault
     * @throws SoapFault
     */
    protected function processException(SoapFault $exception): AuthenticationFault
    {
        if (
            is_object($exception->detail ?? null)
            && is_object($exception->detail->authenticationFault ?? null)
        ) {
            return new AuthenticationFault(
                $exception->detail->authenticationFault->errorCode,
                $exception->detail->authenticationFault->errorMessage
            );
        }

        throw $exception;
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return $this->endpoint[static::$environment];
    }
}