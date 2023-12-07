<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Api;

use Dhl\Sdk\ParcelDe\Shipping\Api\Data\OrderConfigurationInterface;
use Dhl\Sdk\ParcelDe\Shipping\Api\Data\ShipmentInterface;
use Dhl\Sdk\ParcelDe\Shipping\Api\Data\ValidationResultInterface;
use Dhl\Sdk\ParcelDe\Shipping\Exception\AuthenticationException;
use Dhl\Sdk\ParcelDe\Shipping\Exception\DetailedServiceException;
use Dhl\Sdk\ParcelDe\Shipping\Exception\ServiceException;

/**
 * @api
 */
interface ShipmentServiceInterface
{
    /**
     * GetVersion is the operation call used to query the latest version available on the web.
     *
     * @throws AuthenticationException
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function getVersion(): string;

    /**
     * ValidateShipmentOrder is the operation call used to validate shipments before booking label and tracking number.
     *
     * @param \stdClass[] $shipmentOrders
     * @param OrderConfigurationInterface|null $configuration
     *
     * @return ValidationResultInterface[]
     *
     * @throws AuthenticationException
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function validateShipments(array $shipmentOrders, OrderConfigurationInterface $configuration = null): array;

    /**
     * CreateShipmentOrder is the operation call used to generate shipments with the relevant DHL Paket labels.
     *
     * @param \stdClass[] $shipmentOrders
     * @param OrderConfigurationInterface|null $configuration
     *
     * @return ShipmentInterface[]
     *
     * @throws AuthenticationException
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function createShipments(array $shipmentOrders, OrderConfigurationInterface $configuration = null): array;

    /**
     * DeleteShipmentOrder is the operation call used to cancel created shipments.
     *
     * Note that cancellation is only possible before the end-of-the-day manifest.
     *
     * @param string[] $shipmentNumbers
     *
     * @return string[]
     *
     * @throws AuthenticationException
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function cancelShipments(
        array $shipmentNumbers,
        string $profile = OrderConfigurationInterface::DEFAULT_PROFILE
    ): array;
}
