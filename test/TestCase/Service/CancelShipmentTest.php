<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\TestCase\Service;

use Dhl\Sdk\ParcelDe\Shipping\Api\Data\AuthenticationStorageInterface;
use Dhl\Sdk\ParcelDe\Shipping\Exception\AuthenticationException;
use Dhl\Sdk\ParcelDe\Shipping\Exception\DetailedServiceException;
use Dhl\Sdk\ParcelDe\Shipping\Exception\ServiceException;
use Dhl\Sdk\ParcelDe\Shipping\Http\HttpServiceFactory;
use Dhl\Sdk\ParcelDe\Shipping\Test\Expectation\CommunicationExpectation;
use Dhl\Sdk\ParcelDe\Shipping\Test\Expectation\ShipmentServiceTestExpectation;
use Dhl\Sdk\ParcelDe\Shipping\Test\Provider\Http\Service\CancelShipmentTestProvider;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;

class CancelShipmentTest extends TestCase
{
    /**
     * @return mixed[]
     */
    public function successDataProvider(): array
    {
        return CancelShipmentTestProvider::cancelShipmentsSuccess();
    }

    /**
     * @return mixed[]
     */
    public function partialSuccessDataProvider(): array
    {
        return CancelShipmentTestProvider::cancelShipmentsPartialSuccess();
    }

    /**
     * @return mixed[]
     */
    public function errorDataProvider(): array
    {
        return CancelShipmentTestProvider::cancelShipmentsError();
    }

    /**
     * Test shipment cancellation success case (all shipments cancelled, no issues).
     *
     * @test
     * @dataProvider successDataProvider
     *
     * @param AuthenticationStorageInterface $authStorage
     * @param string[] $shipmentNumbers
     * @param string $responseBody
     *
     * @throws AuthenticationException
     * @throws ServiceException
     */
    public function cancelShipmentsSuccess(
        AuthenticationStorageInterface $authStorage,
        array $shipmentNumbers,
        string $responseBody
    ): void {
        $statusCode = count($shipmentNumbers) > 1 ? 207 : 200;
        $reasonPhrase = count($shipmentNumbers) > 1 ? 'Multi-status' : 'OK';

        $httpClient = new Client();
        $logger = new TestLogger();

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $shipmentResponse = $responseFactory
            ->createResponse($statusCode, $reasonPhrase)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream($responseBody));

        $httpClient->setDefaultResponse($shipmentResponse);

        $serviceFactory = new HttpServiceFactory($httpClient, Client::class);
        $service = $serviceFactory->createShipmentService($authStorage, $logger, true);

        $result = $service->cancelShipments($shipmentNumbers);

        ShipmentServiceTestExpectation::assertAllShipmentsCancelled(
            $httpClient->getLastRequest()->getUri()->getQuery(),
            $responseBody,
            $result
        );

        // assert successful communication gets logged.
        CommunicationExpectation::assertCommunicationLogged(
            $httpClient->getLastRequest()->getUri()->getQuery(),
            $responseBody,
            $logger
        );
    }

    /**
     * Test shipment cancellation partial success case (some shipments cancelled).
     *
     * @test
     * @dataProvider partialSuccessDataProvider
     *
     * @param AuthenticationStorageInterface $authStorage
     * @param string[] $shipmentNumbers
     * @param string $responseBody
     *
     * @throws AuthenticationException
     * @throws ServiceException
     */
    public function cancelShipmentsPartialSuccess(
        AuthenticationStorageInterface $authStorage,
        array $shipmentNumbers,
        string $responseBody
    ): void {
        $statusCode = 207;
        $reasonPhrase = 'Multi-status';

        $httpClient = new Client();
        $logger = new TestLogger();

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $shipmentResponse = $responseFactory
            ->createResponse($statusCode, $reasonPhrase)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream($responseBody));

        $httpClient->setDefaultResponse($shipmentResponse);

        $serviceFactory = new HttpServiceFactory($httpClient, Client::class);
        $service = $serviceFactory->createShipmentService($authStorage, $logger, true);

        $result = $service->cancelShipments($shipmentNumbers);

        ShipmentServiceTestExpectation::assertSomeShipmentsCancelled(
            $httpClient->getLastRequest()->getUri()->getQuery(),
            $responseBody,
            $result
        );

        CommunicationExpectation::assertCommunicationLogged(
            $httpClient->getLastRequest()->getUri()->getQuery(),
            $responseBody,
            $logger
        );
    }

    /**
     * Test shipment cancellation failure case.
     *
     * @test
     * @dataProvider errorDataProvider
     *
     * @param AuthenticationStorageInterface $authStorage
     * @param string[] $shipmentNumbers
     * @param string $responseBody
     *
     * @throws AuthenticationException
     * @throws ServiceException
     */
    public function cancelShipmentsError(
        AuthenticationStorageInterface $authStorage,
        array $shipmentNumbers,
        string $responseBody
    ): void {
        $statusCode = count($shipmentNumbers) > 1 ? 207 : 400;
        $reasonPhrase = count($shipmentNumbers) > 1 ? 'Multi-status' : 'Bad Request';

        $this->expectException(DetailedServiceException::class);
        $this->expectExceptionCode($statusCode);

        $httpClient = new Client();
        $logger = new TestLogger();

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $shipmentResponse = $responseFactory
            ->createResponse($statusCode, $reasonPhrase)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream($responseBody));

        $httpClient->setDefaultResponse($shipmentResponse);

        $serviceFactory = new HttpServiceFactory($httpClient, Client::class);
        $service = $serviceFactory->createShipmentService($authStorage, $logger, true);

        try {
            $service->cancelShipments($shipmentNumbers);
        } catch (DetailedServiceException $exception) {
            CommunicationExpectation::assertErrorsLogged(
                (string) $statusCode,
                $responseBody,
                $logger
            );

            throw $exception;
        }
    }
}
