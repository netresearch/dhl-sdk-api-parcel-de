<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Api\Data;

/**
 * @api
 */
interface ShipmentInterface
{
    public const LABEL_TYPE_SHIPMENT = 'label_shipment';
    public const LABEL_TYPE_RETURN = 'label_return';
    public const LABEL_TYPE_EXPORT = 'label_export';
    public const LABEL_TYPE_COD = 'label_cod';
    public const LABEL_TYPE_OTHER = 'label_other';

    public function getRequestIndex(): int;

    public function getShipmentNumber(): string;

    public function getReturnShipmentNumber(): string;

    public function getShipmentLabel(): string;

    public function getReturnLabel(): string;

    public function getExportLabel(): string;

    public function getCodLabel(): string;

    /**
     * @return string[]
     */
    public function getLabels(): array;
}
