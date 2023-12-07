<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\Provider\RequestData;

use Dhl\Sdk\ParcelDe\Shipping\Api\ShipmentOrderRequestBuilderInterface;
use Dhl\Sdk\ParcelDe\Shipping\Exception\RequestValidatorException;
use Dhl\Sdk\ParcelDe\Shipping\Model\Bcs\CreateShipment\RequestType\ShipmentOrderType;

abstract class AbstractRequestData
{
    protected $sequenceNumber = '';

    public function getSequenceNumber(): string
    {
        return $this->sequenceNumber;
    }

    public function setSequenceNumber(string $sequenceNumber): void
    {
        $this->sequenceNumber = $sequenceNumber;
    }

    abstract public function get(): array;

    abstract protected function setBuilderData(ShipmentOrderRequestBuilderInterface $builder, array $data): void;

    /**
     * Create a shipment order using the given request builder in the format specified by request type.
     *
     * Optionally, replace certain fields of the original data before building the request object.
     *
     * @see ShipmentOrderRequestBuilderInterface::REQUEST_TYPE_SOAP
     * @see ShipmentOrderRequestBuilderInterface::REQUEST_TYPE_REST
     *
     * @return ShipmentOrderType|\JsonSerializable
     * @throws RequestValidatorException
     */
    public function createShipmentOrder(
        ShipmentOrderRequestBuilderInterface $builder,
        array $replace = []
    ): object {
        $builderData = $this->get();
        $replace = array_intersect_key($replace, $builderData);
        $this->setBuilderData($builder, array_merge($builderData, $replace));
        return $builder->create();
    }
}
