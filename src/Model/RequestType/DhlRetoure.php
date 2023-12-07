<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class DhlRetoure implements \JsonSerializable
{
    private ?string $refNo = null;

    public function __construct(
        private readonly string $billingNumber,
        private readonly \JsonSerializable|ReturnAddress $returnAddress
    ) {
    }

    public function setRefNo(?string $refNo): void
    {
        $this->refNo = $refNo;
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
