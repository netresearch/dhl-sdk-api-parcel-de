<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class MonetaryValue implements \JsonSerializable
{
    /**
     * @param string $currency ISO 4217 three-character currency code accepted. Recommended to use EUR where possible.
     * @param float $value Numeric value.
     */
    public function __construct(private readonly string $currency, private readonly float $value)
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
