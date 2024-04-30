<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Service;

use Dhl\Sdk\ParcelDe\Shipping\Api\Data\AuthenticationStorageInterface;
use Dhl\Sdk\ParcelDe\Shipping\Api\ServiceFactoryInterface;
use Dhl\Sdk\ParcelDe\Shipping\Api\ShipmentServiceInterface;
use Dhl\Sdk\ParcelDe\Shipping\Exception\ServiceExceptionFactory;
use Dhl\Sdk\ParcelDe\Shipping\Http\HttpServiceFactory;
use Http\Discovery\Exception\NotFoundException;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Log\LoggerInterface;

class ServiceFactory implements ServiceFactoryInterface
{
    public function __construct(private readonly string $userAgent = '')
    {
    }

    public function createShipmentService(
        AuthenticationStorageInterface $authStorage,
        LoggerInterface $logger,
        bool $sandboxMode = false
    ): ShipmentServiceInterface {
        try {
            $httpClient = Psr18ClientDiscovery::find();
        } catch (NotFoundException $exception) {
            throw ServiceExceptionFactory::createServiceException($exception);
        }

        if ($sandboxMode) {
            $httpServiceFactory = new HttpServiceFactory($httpClient, $this->userAgent);
        } else {
            $httpServiceFactory = HttpServiceFactory::withSchemaValidationDisabled($httpClient, $this->userAgent);
        }

        return $httpServiceFactory->createShipmentService($authStorage, $logger, $sandboxMode);
    }
}
