<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\TestCase\Service;

use Dhl\Sdk\ParcelDe\Shipping\Api\Data\AuthenticationStorageInterface;
use Dhl\Sdk\ParcelDe\Shipping\Exception\AuthenticationException;
use Dhl\Sdk\ParcelDe\Shipping\Exception\DetailedServiceException;
use Dhl\Sdk\ParcelDe\Shipping\Exception\RequestValidatorException;
use Dhl\Sdk\ParcelDe\Shipping\Exception\ServiceException;
use Dhl\Sdk\ParcelDe\Shipping\Http\HttpServiceFactory;
use Dhl\Sdk\ParcelDe\Shipping\Service\ShipmentService\OrderConfiguration;
use Dhl\Sdk\ParcelDe\Shipping\Test\Provider\Http\Service\ValidateShipmentTestProvider;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Log\Test\TestLogger;

class SchemaValidatorTest extends TestCase
{
    /**
     * @return mixed[]
     * @throws RequestValidatorException
     */
    public function successDataProvider(): array
    {
        return ValidateShipmentTestProvider::validateShipmentsSuccess();
    }

    /**
     * @return mixed[]
     * @throws RequestValidatorException
     */
    public function validationErrorDataProvider(): array
    {
        return ValidateShipmentTestProvider::validateShipmentsError();
    }

    /**
     * Test shipment order requests with valid request message.
     *
     * @test
     * @dataProvider successDataProvider
     *
     * @param AuthenticationStorageInterface $authStorage
     * @param \JsonSerializable[] $shipmentOrders
     * @param string $responseBody
     *
     * @throws AuthenticationException
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function passValidation(
        AuthenticationStorageInterface $authStorage,
        array $shipmentOrders,
        string $responseBody
    ) {
        $statusCode = count($shipmentOrders) > 1 ? 207 : 200;
        $reasonPhrase = count($shipmentOrders) > 1 ? 'Multi-status' : 'OK';

        $httpClient = new Client();
        $logger = new TestLogger();

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $labelResponse = $responseFactory
            ->createResponse($statusCode, $reasonPhrase)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream($responseBody));

        $httpClient->setDefaultResponse($labelResponse);

        $serviceFactory = new HttpServiceFactory($httpClient, Client::class);
        $service = $serviceFactory->createShipmentService($authStorage, $logger, true);

        $service->validateShipments($shipmentOrders, new OrderConfiguration());

        $lastRequest = $httpClient->getLastRequest();
        self::assertInstanceOf(RequestInterface::class, $lastRequest); // request should be sent
    }

    /**
     * Test shipment order requests with invalid request message.
     *
     * @test
     * @dataProvider validationErrorDataProvider
     *
     * @param AuthenticationStorageInterface $authStorage
     * @param \JsonSerializable[] $shipmentOrders
     *
     * @throws AuthenticationException
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function failValidation(
        AuthenticationStorageInterface $authStorage,
        array $shipmentOrders
    ) {
        $this->expectException(DetailedServiceException::class);

        $httpClient = new Client();
        $logger = new TestLogger();

        $serviceFactory = new HttpServiceFactory($httpClient, Client::class);
        $service = $serviceFactory->createShipmentService($authStorage, $logger, true);

        try {
            $service->validateShipments($shipmentOrders, new OrderConfiguration());
        } catch (ServiceException $exception) {
            $lastRequest = $httpClient->getLastRequest();
            self::assertFalse($lastRequest); // no request should be sent

            throw $exception;
        }
    }
}
