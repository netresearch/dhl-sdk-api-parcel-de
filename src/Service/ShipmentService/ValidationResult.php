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

    /**
     * @return string
     */
    public function getSequenceNumber(): string
    {
        return $this->sequenceNumber;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
