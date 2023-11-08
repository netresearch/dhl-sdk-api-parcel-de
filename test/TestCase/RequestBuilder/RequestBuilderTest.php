<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\TestCase\RequestBuilder;

use Dhl\Sdk\ParcelDe\Shipping\Api\Data\AuthenticationStorageInterface;
use Dhl\Sdk\ParcelDe\Shipping\Api\ShipmentOrderRequestBuilderInterface;
use Dhl\Sdk\ParcelDe\Shipping\Exception\RequestValidatorException;
use Dhl\Sdk\ParcelDe\Shipping\Exception\ServiceException;
use Dhl\Sdk\ParcelDe\Shipping\Http\HttpServiceFactory;
use Dhl\Sdk\ParcelDe\Shipping\RequestBuilder\ShipmentOrderRequestBuilder;
use Dhl\Sdk\ParcelDe\Shipping\Service\ShipmentService\OrderConfiguration;
use Dhl\Sdk\ParcelDe\Shipping\Test\Expectation\RequestTypeExpectation as Expectation;
use Dhl\Sdk\ParcelDe\Shipping\Test\Provider\Http\Credentials\AuthenticationStorageProvider;
use Dhl\Sdk\ParcelDe\Shipping\Test\Provider\RequestData\AbstractRequestData;
use Dhl\Sdk\ParcelDe\Shipping\Test\Provider\RequestData\CrossBorderWithServices;
use Dhl\Sdk\ParcelDe\Shipping\Test\Provider\RequestData\Domestic;
use Dhl\Sdk\ParcelDe\Shipping\Test\Provider\RequestData\DomesticWithServices;
use Dhl\Sdk\ParcelDe\Shipping\Test\Provider\RequestData\Locker;
use Dhl\Sdk\ParcelDe\Shipping\Test\Provider\RequestData\POBox;
use Dhl\Sdk\ParcelDe\Shipping\Test\Provider\RequestData\PostOffice;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class RequestBuilderTest extends TestCase
{
    private const REQUEST_TYPE = ShipmentOrderRequestBuilderInterface::REQUEST_TYPE_REST;

    /**
     * @return mixed[]
     * @throws \Exception
     */
    public function simpleDataProvider(): array
    {
        $response = __DIR__ . '/../../Provider/_files/createshipment/singleShipmentSuccess.json';
        $authStorage = AuthenticationStorageProvider::authSuccess();
        $requestData = [new Domestic()];
        // response does not matter really, just to make it not fail
        $responseBody = \file_get_contents($response);

        return [
            'label request' => [$authStorage, $requestData, $responseBody],
        ];
    }

    /**
     * @return mixed[]
     * @throws \Exception
     */
    public function complexDataProvider(): array
    {
        $response = __DIR__ . '/../../Provider/_files/createshipment/singleShipmentSuccess.json';
        $authStorage = AuthenticationStorageProvider::authSuccess();
        $requestData = [
            new CrossBorderWithServices(),
            new DomesticWithServices(),
            new Locker(),
            new PostOffice(),
            new POBox(),
        ];

        // response does not matter really, just to make it not fail
        $responseBody = \file_get_contents($response);

        return [
            'label request' => [$authStorage, $requestData, $responseBody],
        ];
    }

    /**
     * @test
     * @dataProvider simpleDataProvider
     *
     * @param AuthenticationStorageInterface $authStorage
     * @param AbstractRequestData[] $requestData
     * @param string $responseBody
     * @throws ServiceException
     */
    public function createMinimalShipmentRequest(
        AuthenticationStorageInterface $authStorage,
        array $requestData,
        string $responseBody
    ): void {
        // mock API communication
        $httpClient = new Client();
        $logger = new NullLogger();

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $labelResponse = $responseFactory
            ->createResponse(200, 'OK')
            ->withBody($streamFactory->createStream($responseBody));

        $httpClient->setDefaultResponse($labelResponse);

        // create service
        $serviceFactory = new HttpServiceFactory($httpClient, Client::class);
        $service = $serviceFactory->createShipmentService($authStorage, $logger, true);

        // build shipment orders
        $shipmentOrders = [];
        $requestValues = [];

        $requestBuilder = new ShipmentOrderRequestBuilder(self::REQUEST_TYPE);

        foreach ($requestData as $data) {
            $shipmentOrders[] = $data->createShipmentOrder($requestBuilder);
            $requestValues[] = $data->get();
        }

        // send shipment orders to service
        $service->createShipments($shipmentOrders, new OrderConfiguration());

        // validate response
        $lastRequest = $httpClient->getLastRequest();
        $requestBody = (string) $lastRequest->getBody();

        Expectation::assertJsonContentsAvailable($requestValues, $requestBody);
    }

    /**
     * @test
     * @dataProvider complexDataProvider
     *
     * @param AuthenticationStorageInterface $authStorage
     * @param AbstractRequestData[] $requestData
     * @param string $responseBody
     * @throws ServiceException
     */
    public function createMultiShipmentRequest(
        AuthenticationStorageInterface $authStorage,
        array $requestData,
        string $responseBody
    ): void {
        // mock API communication
        $httpClient = new Client();
        $logger = new NullLogger();

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $labelResponse = $responseFactory
            ->createResponse(200, 'OK')
            ->withBody($streamFactory->createStream($responseBody));

        $httpClient->setDefaultResponse($labelResponse);

        // create service
        $serviceFactory = new HttpServiceFactory($httpClient, Client::class);
        $service = $serviceFactory->createShipmentService($authStorage, $logger, true);

        // build shipment orders
        $shipmentOrders = [];
        $requestValues = [];

        $requestBuilder = new ShipmentOrderRequestBuilder(self::REQUEST_TYPE);

        foreach ($requestData as $data) {
            $shipmentOrders[] = $data->createShipmentOrder($requestBuilder);
            $requestValues[] = $data->get();
        }

        // send shipment orders to service
        $service->createShipments($shipmentOrders, new OrderConfiguration());

        // unset values that are not supported at the REST API
        unset($requestValues[1]['returnReceipt']);
        unset($requestValues[2]['packstationState']);
        unset($requestValues[2]['packstationCountry']);
        unset($requestValues[3]['postfilialState']);
        unset($requestValues[3]['postfilialCountry']);

        // unset address data that are not transmitted with delivery location (post office / po box) shipments
        unset($requestValues[3]['recipientName']);
        unset($requestValues[3]['recipientCountryCode']);
        unset($requestValues[3]['recipientPostalCode']);
        unset($requestValues[3]['recipientCity']);
        unset($requestValues[3]['recipientStreet']);
        unset($requestValues[3]['recipientStreetNumber']);
        unset($requestValues[4]['recipientName']);
        unset($requestValues[4]['recipientCountryCode']);
        unset($requestValues[4]['recipientPostalCode']);
        unset($requestValues[4]['recipientCity']);
        unset($requestValues[4]['recipientStreet']);
        unset($requestValues[4]['recipientStreetNumber']);

        // validate response
        $lastRequest = $httpClient->getLastRequest();
        $requestBody = (string) $lastRequest->getBody();

        Expectation::assertJsonContentsAvailable($requestValues, $requestBody);
    }

    /**
     * Assert that request builder throws exception if shipper data is missing.
     *
     * @test
     * @throws RequestValidatorException
     */
    public function validationExceptionOnMissingShipper()
    {
        $this->expectException(RequestValidatorException::class);
        $this->expectExceptionMessage(ShipmentOrderRequestBuilderInterface::MSG_MISSING_SHIPPER);

        $builder = new ShipmentOrderRequestBuilder(self::REQUEST_TYPE);
        $builder->setShipperAccount('33333333330101');
        $builder->setRecipientAddress('John Doe', 'DEU', '53113', 'Bonn', 'Charles-de-Gaulle-Straße', '20');
        $builder->setShipmentDetails('V01PAK', new \DateTime(date('c', time() + 60 * 60 * 24)));
        $builder->setPackageDetails(2.4);
        $builder->create();
    }

    /**
     * Assert that request builder throws exception if recipient data is missing.
     *
     * @test
     * @throws RequestValidatorException
     */
    public function validationExceptionOnMissingConsignee()
    {
        $this->expectException(RequestValidatorException::class);
        $this->expectExceptionMessage(ShipmentOrderRequestBuilderInterface::MSG_MISSING_RECIPIENT);

        $builder = new ShipmentOrderRequestBuilder(self::REQUEST_TYPE);
        $builder->setShipperAccount('33333333330101');
        $builder->setShipperAddress('Netresearch GmbH & Co.KG', 'DEU', '04229', 'Leipzig', 'Nonnenstraße', '11d');
        $builder->setShipmentDetails('V01PAK', new \DateTime(date('c', time() + 60 * 60 * 24)));
        $builder->setPackageDetails(2.4);
        $builder->create();
    }

    /**
     * Assert that request builder throws exception if contact data is missing for Post Office delivery.
     *
     * @test
     * @throws RequestValidatorException
     */
    public function validationExceptionOnMissingConsigneeContact()
    {
        $this->expectException(RequestValidatorException::class);
        $this->expectExceptionMessage(ShipmentOrderRequestBuilderInterface::MSG_MISSING_CONTACT);

        $builder = new ShipmentOrderRequestBuilder(self::REQUEST_TYPE);
        $builder->setShipperAccount('33333333330101');
        $builder->setShipperAddress('Netresearch GmbH & Co.KG', 'DEU', '04229', 'Leipzig', 'Nonnenstraße', '11d');
        $builder->setPostfiliale('Jane Doe', '502', 'DEU', '53113', 'Bonn');
        $builder->setShipmentDetails('V01PAK', new \DateTime(date('c', time() + 60 * 60 * 24)));
        $builder->setPackageDetails(2.4);
        $builder->create();
    }
}
