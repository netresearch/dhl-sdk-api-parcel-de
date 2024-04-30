<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\ResponseType;

class Label
{
    private ?string $b64 = null;

    private ?string $zpl2 = null;

    private ?string $url = null;

    private ?string $fileFormat = null;

    public function getB64(): ?string
    {
        return $this->b64;
    }

    public function getZpl2(): ?string
    {
        return $this->zpl2;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getFileFormat(): ?string
    {
        return $this->fileFormat;
    }
}
