<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class CustomsItem implements \JsonSerializable
{
    /**
     * A valid country code consisting of three characters according to ISO 3166-1 alpha-3.
     *
     * @var string|null
     */
    private ?string $countryOfOrigin;

    /**
     * Harmonized System Code aka Customs tariff number.
     *
     * @var string|null
     */
    private ?string $hsCode;

    /**
     * @param string $itemDescription
     * @param int $packagedQuantity Item count of the unit/position
     * @param \JsonSerializable|MonetaryValue $itemValue Customs value amount of the unit/position
     * @param \JsonSerializable|Weight $itemWeight Weight of item or shipment
     */
    public function __construct(
        private readonly string $itemDescription,
        private readonly int $packagedQuantity,
        private readonly \JsonSerializable|MonetaryValue $itemValue,
        private readonly \JsonSerializable|Weight $itemWeight,
    ) {
    }

    public function setCountryOfOrigin(?string $countryOfOrigin): void
    {
        $this->countryOfOrigin = $countryOfOrigin;
    }

    public function setHsCode(?string $hsCode): void
    {
        $this->hsCode = $hsCode;
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
