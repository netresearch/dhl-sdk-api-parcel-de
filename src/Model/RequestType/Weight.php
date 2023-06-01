<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class Weight implements \JsonSerializable
{

    /**
     * @param string $uom Metric unit for weight. Allowed values: "g", "kg".
     * @param float $value Numeric value.
     */
    public function __construct(private readonly string $uom, private readonly float $value)
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
