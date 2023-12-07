<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class Dimension implements \JsonSerializable
{
    /**
     * @param string $uom Unit of metric, applies to all dimensions contained. Allowed values: "cm", "mm"
     */
    public function __construct(
        private readonly string $uom,
        private readonly int $height,
        private readonly int $length,
        private readonly int $width,
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
