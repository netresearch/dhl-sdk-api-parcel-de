<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Service\ShipmentService;

use Dhl\Sdk\ParcelDe\Shipping\Api\Data\OrderConfigurationInterface;

class OrderConfiguration implements OrderConfigurationInterface
{
    public function __construct(
        private readonly ?bool $mustEncode = null,
        private readonly ?bool $combinedPrinting = null,
        private readonly ?string $docFormat = null,
        private readonly ?string $printFormat = null,
        private readonly ?string $printFormatReturn = null,
        private readonly ?string $profile = null,
    ) {
    }

    public function mustEncode(): ?bool
    {
        return $this->mustEncode;
    }

    public function isCombinedPrinting(): ?bool
    {
        return $this->combinedPrinting;
    }

    public function getDocFormat(): ?string
    {
        return $this->docFormat;
    }

    public function getPrintFormat(): ?string
    {
        return $this->printFormat;
    }

    public function getPrintFormatReturn(): ?string
    {
        return $this->printFormatReturn;
    }

    public function getProfile(): string
    {
        return $this->profile ?: OrderConfigurationInterface::DEFAULT_PROFILE;
    }
}
