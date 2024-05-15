<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\ResponseType;

class Status
{
    private string $title;

    private int $statusCode;

    private ?string $instance = null;

    private ?string $detail = null;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getInstance(): ?string
    {
        return $this->instance;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }
}
