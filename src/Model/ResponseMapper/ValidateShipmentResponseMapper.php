<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\ResponseMapper;

use Dhl\Sdk\ParcelDe\Shipping\Api\Data\ValidationResultInterface;
use Dhl\Sdk\ParcelDe\Shipping\Model\ResponseType\ValidationMessage;
use Dhl\Sdk\ParcelDe\Shipping\Model\ShipmentResponse;
use Dhl\Sdk\ParcelDe\Shipping\Service\ShipmentService\ValidationResult;

class ValidateShipmentResponseMapper
{
    /**
     * Map the webservice data structure to response objects suitable for third-party consumption.
     *
     * @return ValidationResultInterface[]
     */
    public function map(ShipmentResponse $response): array
    {
        $results = [];

        foreach ($response->getItems() as $index => $item) {
            if (!empty($item->getValidationMessages())) {
                $itemMessages = array_map(
                    fn(ValidationMessage $itemMessage): string => sprintf(
                        '%s (%s): %s',
                        $itemMessage->getValidationState(),
                        $itemMessage->getProperty(),
                        $itemMessage->getValidationMessage()
                    ),
                    $item->getValidationMessages()
                );

                $message = implode("\n", $itemMessages);
            } else {
                $message = $item->getStatus()->getDetail() ?? $item->getStatus()->getTitle();
            }

            $results[] = new ValidationResult($index, ($item->getStatus()->getStatusCode() === 200), $message);
        }

        return $results;
    }
}
