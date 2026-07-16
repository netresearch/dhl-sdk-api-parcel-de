<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\Provider\RequestData;

use Dhl\Sdk\ParcelDe\Shipping\Api\ShipmentOrderRequestBuilderInterface;

class CrossBorderUsd extends CrossBorder
{
    #[\Override]
    public function get(): array
    {
        return array_merge(parent::get(), [
            'currency' => 'USD',
            'exportItem1Currency' => 'USD',
            'exportItem2Currency' => 'USD',
        ]);
    }

    #[\Override]
    protected function setBuilderData(ShipmentOrderRequestBuilderInterface $builder, array $data): void
    {
        parent::setBuilderData($builder, $data);

        $builder->setCustomsDetails(
            $data['exportType'],
            $data['placeOfCommital'],
            $data['additionalFee'],
            $data['exportTypeDescription'],
            $data['termsOfTrade'],
            $data['invoiceNumber'],
            $data['permitNumber'],
            $data['attestationNumber'],
            $data['electronicExportNotification'],
            null,
            null,
            null,
            $data['currency']
        );
    }
}
