<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model;

use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\Shipment;

class ShipmentOrderRequest implements \JsonSerializable
{
    private ?string $profile = null;

    /**
     * @param \JsonSerializable[]|Shipment[] $shipments
     */
    public function __construct(private readonly array $shipments)
    {
    }

    public function setProfile(?string $profile): void
    {
        $this->profile = $profile;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return mixed[] Serializable object properties
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
