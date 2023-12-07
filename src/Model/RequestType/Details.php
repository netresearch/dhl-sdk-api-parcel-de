<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class Details implements \JsonSerializable
{
    /**
     * Physical dimensions (aka 'Gurtmass') of the parcel.
     *
     * If you provide the dimension information, all attributes need to be provided.
     * You cannot provide just the height, for example. If you provide length,
     * width, and height in millimeters, they will be rounded to full cm.
     */
    private \JsonSerializable|Dimension|null $dim = null;

    public function __construct(private readonly \JsonSerializable|Weight $weight)
    {
    }

    public function setDim(\JsonSerializable|Dimension|null $dimension): void
    {
        $this->dim = $dimension;
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
