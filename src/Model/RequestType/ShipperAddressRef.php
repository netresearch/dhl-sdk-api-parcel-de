<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class ShipperAddressRef implements ShipperInterface, \JsonSerializable
{
    /**
     * @param string $shipperRef Contains a reference to the Shipper data configured in GKP
     *                           (Geschäftskundenportal - Business Costumer Portal). Can be used
     *                           instead of a detailed shipper address. The shipper reference can be used
     *                           to print a company logo which is configured in GKP onto the label.
     */
    public function __construct(private readonly string $shipperRef)
    {
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
