<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\Provider\RequestData;

use Dhl\Sdk\ParcelDe\Shipping\Api\ShipmentOrderRequestBuilderInterface;

class Locker extends AbstractRequestData
{
    public function get(): array
    {
        $tsShip = time() + 60 * 60 * 24; // tomorrow

        return [
            'requestIndex' => $this->getRequestIndex(),
            'billingNumber' => '33333333330101',
            'productCode' => 'V01PAK',
            'shipDate' => new \DateTime(date('Y-m-d', $tsShip)),
            'shipperReference' => 'ShipperWithLogo',
            'packstationNumber' => '139',
            'packstationPostalCode' => '53113',
            'packstationCity' => 'Bonn',
            'packstationRecipientName' => 'Jane Doe',
            'packstationPostNumber' => '12345678',
            'packstationState' => 'NRW',
            'packstationCountryCode' => 'DEU',
            'packstationCountry' => 'Deutschland',
            'packageWeight' => 4.5,
        ];
    }

    protected function setBuilderData(ShipmentOrderRequestBuilderInterface $builder, array $data): void
    {
        $builder->setRequestIndex($data['requestIndex']);
        $builder->setShipperAccount($data['billingNumber']);
        $builder->setShipperReference($data['shipperReference']);

        $builder->setPackstation(
            $data['packstationRecipientName'],
            $data['packstationPostNumber'],
            $data['packstationNumber'],
            $data['packstationCountryCode'],
            $data['packstationPostalCode'],
            $data['packstationCity'],
            $data['packstationState'],
            $data['packstationCountry']
        );

        $builder->setShipmentDetails(
            $data['productCode'],
            $data['shipDate']
        );

        $builder->setPackageDetails($data['packageWeight']);
    }
}
