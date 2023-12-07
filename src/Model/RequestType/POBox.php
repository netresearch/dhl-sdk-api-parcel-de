<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class POBox implements ConsigneeInterface, \JsonSerializable
{
    /**
     * An optional, additional line of name information.
     */
    private ?string $name2 = null;

    /**
     * An optional, additional line of name information.
     */
    private ?string $name3 = null;

    /**
     * Email address of the consignee.
     */
    private ?string $email = null;

    /**
     * @param string $name1 Line 1 of name information
     * @param int $poBoxID Number of P.O. Box (Postfach)
     * @param string $city City where the facility is located
     * @param string $country A valid country code consisting of three characters according to ISO 3166-1 alpha-3
     */
    public function __construct(
        private readonly string $name1,
        private readonly int $poBoxID,
        private readonly string $postalCode,
        private readonly string $city,
        private readonly string $country
    ) {
    }

    public function setName2(?string $name2): void
    {
        $this->name2 = $name2;
    }

    public function setName3(?string $name3): void
    {
        $this->name3 = $name3;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
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
