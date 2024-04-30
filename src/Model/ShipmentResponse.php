<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model;

class ShipmentResponse
{
    private ?ResponseType\Status $status = null;

    /**
     * @var \Dhl\Sdk\ParcelDe\Shipping\Model\ResponseType\Item[]
     */
    private array $items;

    public function getStatus(): ?ResponseType\Status
    {
        return $this->status;
    }

    /**
     * @return \Dhl\Sdk\ParcelDe\Shipping\Model\ResponseType\Item[]
     */
    public function getItems(): array
    {
        if ($this->items === []) {
            return [];
        }

        return $this->items;
    }
}
