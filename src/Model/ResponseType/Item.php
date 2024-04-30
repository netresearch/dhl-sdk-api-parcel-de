<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\ResponseType;

class Item
{
    private Status $sstatus;

    /**
     * @var \Dhl\Sdk\ParcelDe\Shipping\Model\ResponseType\ValidationMessage[]
     */
    private array $validationMessages = [];

    private ?string $shipmentNo = null;

    private ?string $returnShipmentNo = null;

    private ?string $shipmentRefNo = null;

    private ?Label $label = null;

    private ?Label $returnLabel = null;

    private ?Label $customsDoc = null;

    private ?Label $codLabel = null;

    public function getStatus(): Status
    {
        return $this->sstatus;
    }

    /**
     * @return \Dhl\Sdk\ParcelDe\Shipping\Model\ResponseType\ValidationMessage[]
     */
    public function getValidationMessages(): array
    {
        return $this->validationMessages;
    }

    public function getShipmentNo(): ?string
    {
        return $this->shipmentNo;
    }

    public function getReturnShipmentNo(): ?string
    {
        return $this->returnShipmentNo;
    }

    public function getShipmentRefNo(): ?string
    {
        return $this->shipmentRefNo;
    }

    public function getLabel(): ?Label
    {
        return $this->label;
    }

    public function getReturnLabel(): ?Label
    {
        return $this->returnLabel;
    }

    public function getCustomsDoc(): ?Label
    {
        return $this->customsDoc;
    }

    public function getCodLabel(): ?Label
    {
        return $this->codLabel;
    }
}
