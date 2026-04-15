<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\Provider\RequestData;

use Dhl\Sdk\ParcelDe\Shipping\Api\ShipmentOrderRequestBuilderInterface;

class CrossBorderWithoutPostalCode extends AbstractRequestData
{
    public function get(): array
    {
        $tsShip = time() + 60 * 60 * 24; // tomorrow

        return [
            'requestIndex' => $this->getRequestIndex(),
            'billingNumber' => '33333333330101',
            'productCode' => 'V53PAK',
            'shipDate' => new \DateTime(date('Y-m-d', $tsShip)),
            'shipperCompany' => 'Netresearch GmbH & Co.KG',
            'shipperCountryCode' => 'DEU',
            'shipperPostalCode' => '04229',
            'shipperCity' => 'Leipzig',
            'shipperStreet' => 'Nonnenstraße',
            'shipperStreetNumber' => '11d',
            'recipientCountryCode' => 'ARE',
            'recipientCity' => 'Dubai',
            'recipientStreet' => 'Sheikh Zayed Road',
            'recipientName' => 'Jane Doe',
            'packageWeight' => 2.4,

            'exportType' => 'OTHER',
            'placeOfCommital' => 'Leipzig',
            'additionalFee' => 5.50,
            'exportTypeDescription' => 'Gift',
            'termsOfTrade' => 'DAP',
            'invoiceNumber' => '1234567890',
            'electronicExportNotification' => false,
            'exportItem1Qty' => 1,
            'exportItem1Desc' => 'T-Shirt',
            'exportItem1Weight' => 0.3,
            'exportItem1Value' => 19.99,
            'exportItem1HsCode' => '61091000',
            'exportItem1Origin' => 'DEU',
        ];
    }

    protected function setBuilderData(ShipmentOrderRequestBuilderInterface $builder, array $data): void
    {
        $builder->setRequestIndex($data['requestIndex']);
        $builder->setShipperAccount($data['billingNumber']);

        $builder->setShipperAddress(
            $data['shipperCompany'],
            $data['shipperCountryCode'],
            $data['shipperPostalCode'],
            $data['shipperCity'],
            $data['shipperStreet'],
            $data['shipperStreetNumber']
        );

        $builder->setRecipientAddress(
            $data['recipientName'],
            $data['recipientCountryCode'],
            '',
            $data['recipientCity'],
            $data['recipientStreet'],
        );

        $builder->setShipmentDetails(
            $data['productCode'],
            $data['shipDate']
        );

        $builder->setPackageDetails(
            $data['packageWeight']
        );

        $builder->setCustomsDetails(
            $data['exportType'],
            $data['placeOfCommital'],
            $data['additionalFee'],
            $data['exportTypeDescription'],
            $data['termsOfTrade'],
            $data['invoiceNumber'],
        );

        $builder->addExportItem(
            $data['exportItem1Qty'],
            $data['exportItem1Desc'],
            $data['exportItem1Value'],
            $data['exportItem1Weight'],
            $data['exportItem1HsCode'],
            $data['exportItem1Origin']
        );
    }
}
