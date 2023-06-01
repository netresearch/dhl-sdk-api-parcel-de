<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Service\ShipmentService;

use Dhl\Sdk\ParcelDe\Shipping\Api\Data\ShipmentInterface;

class Shipment implements ShipmentInterface
{
    public function __construct(
        private readonly string $sequenceNumber,
        private readonly string $shipmentNumber,
        private readonly string $returnShipmentNumber,
        private readonly string $shipmentLabel,
        private readonly string $returnLabel,
        private readonly string $exportLabel,
        private readonly string $codLabel
    ) {
    }

    public function getSequenceNumber(): string
    {
        return $this->sequenceNumber;
    }

    public function getShipmentNumber(): string
    {
        return $this->shipmentNumber;
    }

    public function getReturnShipmentNumber(): string
    {
        return $this->returnShipmentNumber;
    }

    public function getShipmentLabel(): string
    {
        return $this->shipmentLabel;
    }

    public function getReturnLabel(): string
    {
        return $this->returnLabel;
    }

    public function getExportLabel(): string
    {
        return $this->exportLabel;
    }

    public function getCodLabel(): string
    {
        return $this->codLabel;
    }

    public function getLabels(): array
    {
        return [
            self::LABEL_TYPE_SHIPMENT => $this->getShipmentLabel(),
            self::LABEL_TYPE_RETURN => $this->getReturnLabel(),
            self::LABEL_TYPE_EXPORT => $this->getExportLabel(),
            self::LABEL_TYPE_COD => $this->getCodLabel(),
        ];
    }
}
