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
     * @param ShipmentResponse $response
     * @return string[]
     */
    public function map(ShipmentResponse $response): array
    {
        return array_map(
            function (Item $responseItem) {
                return $responseItem->getShipmentNo();
            },
            array_filter(
                $response->getItems(),
                function (Item $responseItem) {
                    return ($responseItem->getStatus()->getStatusCode() === 200);
                }
            )
        );
    }
}
