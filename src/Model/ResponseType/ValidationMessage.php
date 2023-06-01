<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\ResponseType;

class ValidationMessage
{
    private ?string $property = null;

    private ?string $validationMessage = null;

    private ?string $validationState = null;

    public function getProperty(): ?string
    {
        return $this->property;
    }

    public function getValidationMessage(): ?string
    {
        return $this->validationMessage;
    }

    public function getValidationState(): ?string
    {
        return $this->validationState;
    }
}
