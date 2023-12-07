<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Service\ShipmentService;

use Dhl\Sdk\ParcelDe\Shipping\Api\Data\ValidationResultInterface;

class ValidationResult implements ValidationResultInterface
{
    public function __construct(
        private readonly string $sequenceNumber,
        private readonly bool $valid,
        private readonly string $message
    ) {
    }

    public function getSequenceNumber(): string
    {
        return $this->sequenceNumber;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
