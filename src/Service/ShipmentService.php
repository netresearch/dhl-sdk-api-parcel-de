<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Service;

use Dhl\Sdk\ParcelDe\Shipping\Api\Data\OrderConfigurationInterface;
use Dhl\Sdk\ParcelDe\Shipping\Api\ShipmentServiceInterface;
use Dhl\Sdk\ParcelDe\Shipping\Exception\AuthenticationErrorHttpException;
use Dhl\Sdk\ParcelDe\Shipping\Exception\DetailedErrorHttpException;
use Dhl\Sdk\ParcelDe\Shipping\Exception\SchemaErrorException;
use Dhl\Sdk\ParcelDe\Shipping\Exception\ServiceExceptionFactory;
use Dhl\Sdk\ParcelDe\Shipping\Model\ResponseMapper\CreateShipmentResponseMapper;
use Dhl\Sdk\ParcelDe\Shipping\Model\ResponseMapper\DeleteShipmentResponseMapper;
use Dhl\Sdk\ParcelDe\Shipping\Model\ResponseMapper\ValidateShipmentResponseMapper;
use Dhl\Sdk\ParcelDe\Shipping\Model\ShipmentOrderRequest;
use Dhl\Sdk\ParcelDe\Shipping\Serializer\JsonSerializer;
use Dhl\Sdk\ParcelDe\Shipping\Service\ShipmentService\OrderConfiguration;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class ShipmentService implements ShipmentServiceInterface
{
    private const OPERATION_ORDERS = 'orders';

    public function __construct(
        private readonly ClientInterface $client,
        private readonly string $baseUrl,
        private readonly JsonSerializer $serializer,
        private readonly ValidateShipmentResponseMapper $validateShipmentResponseMapper,
        private readonly CreateShipmentResponseMapper $createShipmentResponseMapper,
        private readonly DeleteShipmentResponseMapper $deleteShipmentResponseMapper,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory
    ) {
    }

    /**
     * Assert that all shipment orders are serializable.
     *
     * @param \stdClass[] $shipmentOrders
     *
     * @throws \Exception
     */
    private function getShipmentOrderRequest(array $shipmentOrders): ShipmentOrderRequest
    {
        foreach ($shipmentOrders as $shipmentOrder) {
            if (!$shipmentOrder instanceof \JsonSerializable) {
                throw new \InvalidArgumentException('Shipment orders must implement JsonSerializable');
            }
        }

        /** @var \JsonSerializable[] $shipmentOrders */
        return new ShipmentOrderRequest($shipmentOrders);
    }

    /**
     * @param string[] $requestParams
     */
    private function getQuery(array $requestParams, ?OrderConfigurationInterface $configuration): string
    {
        if ($configuration->mustEncode()) {
            $requestParams['mustEncode'] = 'true';
        }

        if ($configuration->isCombinedPrinting() !== null) {
            $requestParams['combine'] = $configuration->isCombinedPrinting() ? 'true' : 'false';
        }

        if ($configuration->getDocFormat() === OrderConfigurationInterface::DOC_FORMAT_ZPL2) {
            $requestParams['docFormat'] = 'ZPL2';
        }

        if ($configuration->getPrintFormat()) {
            $requestParams['printFormat'] = $configuration->getPrintFormat();
        }

        if ($configuration->getPrintFormatReturn()) {
            $requestParams['retourePrintFormat'] = $configuration->getPrintFormatReturn();
        }

        return http_build_query($requestParams);
    }

    public function getVersion(): string
    {
        try {
            $httpRequest = $this->requestFactory->createRequest('GET', $this->baseUrl);

            $response = $this->client->sendRequest($httpRequest);
            $responseJson = (string) $response->getBody();

            $responseData = \json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);

            return $responseData['backend']['version'] ?? '';
        } catch (\Throwable $exception) {
            throw ServiceExceptionFactory::createServiceException($exception);
        }
    }

    public function validateShipments(array $shipmentOrders, OrderConfigurationInterface $configuration = null): array
    {
        if (!$configuration instanceof OrderConfigurationInterface) {
            $configuration = new OrderConfiguration();
        }

        $query = $this->getQuery(['validate' => 'true'], $configuration);
        $uri = sprintf('%s/%s?%s', $this->baseUrl, self::OPERATION_ORDERS, $query);

        try {
            $shipmentOrderRequest = $this->getShipmentOrderRequest($shipmentOrders);
            $shipmentOrderRequest->setProfile($configuration->getProfile());

            $payload = $this->serializer->encode($shipmentOrderRequest);
            $stream = $this->streamFactory->createStream($payload);

            $httpRequest = $this->requestFactory->createRequest('POST', $uri)->withBody($stream);

            $response = $this->client->sendRequest($httpRequest);
            $responseJson = (string) $response->getBody();
            $responseObject = $this->serializer->decode($responseJson);

            return $this->validateShipmentResponseMapper->map($responseObject);
        } catch (AuthenticationErrorHttpException $exception) {
            throw ServiceExceptionFactory::createAuthenticationException($exception);
        } catch (DetailedErrorHttpException | SchemaErrorException $exception) {
            throw ServiceExceptionFactory::createDetailedServiceException($exception);
        } catch (\Throwable $exception) {
            throw ServiceExceptionFactory::createServiceException($exception);
        }
    }

    public function createShipments(array $shipmentOrders, OrderConfigurationInterface $configuration = null): array
    {
        if (!$configuration instanceof OrderConfigurationInterface) {
            $configuration = new OrderConfiguration();
        }

        $query = $this->getQuery([], $configuration);
        $uri = sprintf('%s/%s', $this->baseUrl, self::OPERATION_ORDERS);
        if ($query !== '') {
            $uri = "$uri?$query";
        }

        try {
            $shipmentOrderRequest = $this->getShipmentOrderRequest($shipmentOrders);
            $shipmentOrderRequest->setProfile($configuration->getProfile());

            $payload = $this->serializer->encode($shipmentOrderRequest);
            $stream = $this->streamFactory->createStream($payload);

            $httpRequest = $this->requestFactory->createRequest('POST', $uri)->withBody($stream);

            $response = $this->client->sendRequest($httpRequest);
            $responseJson = (string) $response->getBody();
            $responseObject = $this->serializer->decode($responseJson);

            return $this->createShipmentResponseMapper->map($responseObject);
        } catch (AuthenticationErrorHttpException $exception) {
            throw ServiceExceptionFactory::createAuthenticationException($exception);
        } catch (DetailedErrorHttpException | SchemaErrorException $exception) {
            throw ServiceExceptionFactory::createDetailedServiceException($exception);
        } catch (\Throwable $exception) {
            throw ServiceExceptionFactory::createServiceException($exception);
        }
    }

    public function cancelShipments(
        array $shipmentNumbers,
        string $profile = OrderConfigurationInterface::DEFAULT_PROFILE
    ): array {
        $shipmentNumbers = array_filter($shipmentNumbers);
        if ($shipmentNumbers === []) {
            return [];
        }

        $requestParams = array_map(
            fn(string $shipmentNumber): string => "shipment=$shipmentNumber",
            $shipmentNumbers
        );
        array_unshift($requestParams, "profile=$profile");

        $uri = sprintf('%s/%s?%s', $this->baseUrl, self::OPERATION_ORDERS, implode('&', $requestParams));

        try {
            $httpRequest = $this->requestFactory->createRequest('DELETE', $uri);

            $response = $this->client->sendRequest($httpRequest);
            $responseJson = (string) $response->getBody();
            $responseObject = $this->serializer->decode($responseJson);

            return $this->deleteShipmentResponseMapper->map($responseObject);
        } catch (AuthenticationErrorHttpException $exception) {
            throw ServiceExceptionFactory::createAuthenticationException($exception);
        } catch (DetailedErrorHttpException $exception) {
            throw ServiceExceptionFactory::createDetailedServiceException($exception);
        } catch (\Throwable $exception) {
            throw ServiceExceptionFactory::createServiceException($exception);
        }
    }
}
