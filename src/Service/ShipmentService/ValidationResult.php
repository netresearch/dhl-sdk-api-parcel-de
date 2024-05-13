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
        private readonly int $requestIndex,
        private readonly bool $valid,
        private readonly string $message
    ) {
    }

    public function getRequestIndex(): int
    {
        return $this->requestIndex;
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
