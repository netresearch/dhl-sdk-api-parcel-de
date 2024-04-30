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
use Dhl\Sdk\ParcelDe\Shipping\Test\Expectation\CommunicationExpectation;
use Dhl\Sdk\ParcelDe\Shipping\Test\Expectation\ShipmentServiceTestExpectation;
use Dhl\Sdk\ParcelDe\Shipping\Test\Provider\Http\Service\CreateShipmentTestProvider;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;

class CreateShipmentTest extends TestCase
{
    /**
     * @return mixed[]
     * @throws RequestValidatorException
     */
    public static function successDataProvider(): array
    {
        return CreateShipmentTestProvider::createShipmentsSuccess();
    }

    /**
     * @return mixed[]
     * @throws RequestValidatorException
     */
    public static function partialSuccessDataProvider(): array
    {
        return CreateShipmentTestProvider::createShipmentsPartialSuccess();
    }

    /**
     * @return mixed[]
     * @throws RequestValidatorException
     */
    public static function validationWarningDataProvider(): array
    {
        return CreateShipmentTestProvider::createShipmentsValidationWarning();
    }

    /**
     * @return mixed[]
     * @throws RequestValidatorException
     */
    public static function validationErrorDataProvider(): array
    {
        return CreateShipmentTestProvider::createShipmentsValidationError();
    }

    /**
     * @return mixed[]
     * @throws RequestValidatorException
     */
    public static function schemaErrorDataProvider(): array
    {
        return CreateShipmentTestProvider::createShipmentsError();
    }

    /**
     * Test shipment success case (all requests valid, no issues).
     *
     *
     * @param \JsonSerializable[] $shipmentOrders
     *
     * @throws AuthenticationException
     * @throws ServiceException
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('successDataProvider')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function createShipmentsSuccess(
        AuthenticationStorageInterface $authStorage,
        array $shipmentOrders,
        string $responseBody
    ): void {
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

        $result = $service->createShipments($shipmentOrders, new OrderConfiguration(true, false));

        $lastRequest = $httpClient->getLastRequest();
        $requestBody = (string) $lastRequest->getBody();

        ShipmentServiceTestExpectation::assertShipmentsBooked(
            $requestBody,
            $responseBody,
            $result
        );

        // assert successful communication gets logged.
        CommunicationExpectation::assertCommunicationLogged(
            $requestBody,
            $responseBody,
            $logger
        );
    }

    /**
     * Test shipment partial success case (some requests valid, some have issues, must encode).
     *
     *
     * @param \JsonSerializable[] $shipmentOrders
     *
     * @throws AuthenticationException
     * @throws ServiceException
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('partialSuccessDataProvider')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function createShipmentsPartialSuccess(
        AuthenticationStorageInterface $authStorage,
        array $shipmentOrders,
        string $responseBody
    ): void {
        $statusCode = 207;
        $reasonPhrase = 'Multi-status';

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

        $result = $service->createShipments($shipmentOrders, new OrderConfiguration(true));

        $lastRequest = $httpClient->getLastRequest();
        $requestBody = (string) $lastRequest->getBody();

        ShipmentServiceTestExpectation::assertShipmentsBooked(
            $requestBody,
            $responseBody,
            $result
        );

        // no "warning" severity for REST APIs
        CommunicationExpectation::assertCommunicationLogged(
            $requestBody,
            $responseBody,
            $logger
        );
    }

    /**
     * Test shipment success case (all requests have issues with WEAK warning severity).
     *
     *
     * @param \JsonSerializable[] $shipmentOrders
     *
     * @throws AuthenticationException
     * @throws ServiceException
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('validationWarningDataProvider')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function createShipmentsValidationWarning(
        AuthenticationStorageInterface $authStorage,
        array $shipmentOrders,
        string $responseBody
    ): void {
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

        $result = $service->createShipments($shipmentOrders, new OrderConfiguration());

        $lastRequest = $httpClient->getLastRequest();
        $requestBody = (string) $lastRequest->getBody();

        ShipmentServiceTestExpectation::assertShipmentsBooked(
            $requestBody,
            $responseBody,
            $result
        );

        // no "warning" severity for REST APIs
        CommunicationExpectation::assertCommunicationLogged(
            $requestBody,
            $responseBody,
            $logger
        );
    }

    /**
     * Test shipment error case (all requests have issues with HARD warning severity).
     *
     *
     * @param \JsonSerializable[] $shipmentOrders
     *
     * @throws ServiceException
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('validationErrorDataProvider')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function createShipmentsValidationError(
        AuthenticationStorageInterface $authStorage,
        array $shipmentOrders,
        string $responseBody
    ): void {
        $statusCode = count($shipmentOrders) > 1 ? 207 : 400;
        $reasonPhrase = count($shipmentOrders) > 1 ? 'Multi-status' : 'Bad Request';

        $this->expectException(DetailedServiceException::class);
        $this->expectExceptionCode($statusCode);

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

        try {
            $service->createShipments($shipmentOrders, new OrderConfiguration());
        } catch (DetailedServiceException $exception) {
            $lastRequest = $httpClient->getLastRequest();
            $requestBody = (string) $lastRequest->getBody();

            CommunicationExpectation::assertErrorsLogged(
                $requestBody,
                $responseBody,
                $logger
            );

            throw $exception;
        }
    }

    /**
     * Test shipment error case (all requests schema invalid) with client-side schema validation.
     *
     *
     * @param \JsonSerializable[] $shipmentOrders
     *
     * @throws ServiceException
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('schemaErrorDataProvider')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function createShipmentsSchemaError(
        AuthenticationStorageInterface $authStorage,
        array $shipmentOrders
    ): void {
        $this->expectException(DetailedServiceException::class);
        $this->expectExceptionCode(0);

        $httpClient = new Client();
        $logger = new TestLogger();

        $serviceFactory = new HttpServiceFactory($httpClient, Client::class);
        $service = $serviceFactory->createShipmentService($authStorage, $logger, true);

        try {
            $service->createShipments($shipmentOrders, new OrderConfiguration());
        } catch (DetailedServiceException $exception) {
            // assert that no request was made
            $lastRequest = $httpClient->getLastRequest();
            self::assertEmpty($lastRequest);
            self::assertTrue($logger->hasErrorThatContains($exception->getMessage()));

            throw $exception;
        }
    }

    /**
     * Test shipment error case (all requests schema invalid) with server-side schema validation.
     *
     *
     * @param \JsonSerializable[] $shipmentOrders
     *
     * @throws ServiceException
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('schemaErrorDataProvider')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function createShipmentsFailure(
        AuthenticationStorageInterface $authStorage,
        array $shipmentOrders,
        string $responseBody
    ): void {
        $statusCode = 400;
        $reasonPhrase = 'Bad Request';

        $this->expectException(DetailedServiceException::class);
        $this->expectExceptionCode($statusCode);

        $httpClient = new Client();
        $logger = new TestLogger();

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $labelResponse = $responseFactory
            ->createResponse($statusCode, $reasonPhrase)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream($responseBody));

        $httpClient->setDefaultResponse($labelResponse);

        $serviceFactory = HttpServiceFactory::withSchemaValidationDisabled($httpClient, Client::class);
        $service = $serviceFactory->createShipmentService($authStorage, $logger, true);

        try {
            $service->createShipments($shipmentOrders, new OrderConfiguration());
        } catch (DetailedServiceException $exception) {
            $lastRequest = $httpClient->getLastRequest();
            $requestBody = (string) $lastRequest->getBody();

            CommunicationExpectation::assertErrorsLogged(
                $requestBody,
                $responseBody,
                $logger
            );

            throw $exception;
        }
    }
}
