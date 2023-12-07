<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\ResponseMapper;

use Dhl\Sdk\ParcelDe\Shipping\Model\ResponseType\Item;
use Dhl\Sdk\ParcelDe\Shipping\Model\ShipmentResponse;

class DeleteShipmentResponseMapper
{
    /**
     * Map the webservice data structure to response objects suitable for third-party consumption.
     *
     * @return string[]
     */
    public function map(ShipmentResponse $response): array
    {
        return array_map(
            fn(Item $responseItem): ?string => $responseItem->getShipmentNo(),
            array_filter(
                $response->getItems(),
                fn(Item $responseItem): bool => $responseItem->getStatus()->getStatusCode() === 200
            )
        );
    }
}
