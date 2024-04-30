<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class Locker implements ConsigneeInterface, \JsonSerializable
{
    /**
     * @param string $name Consignee Name
     * @param int $lockerID Packstationnummer: Three-digit number identifying the parcel locker
     * @param string $city City where the locker is located
     * @param string $country A valid country code consisting of three characters according to ISO 3166-1 alpha-3
     * @param string $postNumber The official account number a private DHL Customer gets upon registration
     */
    public function __construct(
        private readonly string $name,
        private readonly int $lockerID,
        private readonly string $postalCode,
        private readonly string $city,
        private readonly string $country,
        private readonly string $postNumber
    ) {
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
