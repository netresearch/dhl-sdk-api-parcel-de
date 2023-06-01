<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class Customs implements \JsonSerializable
{
    /**
     * Mandatory if export type is 'OTHER'
     *
     * @var string|null
     */
    private ?string $exportDescription;

    /**
     * Postage costs billed in the invoice.
     *
     * @var \JsonSerializable|MonetaryValue|null
     */
    private \JsonSerializable|MonetaryValue|null $postalCharges;

    /**
     * Aka 'Terms of Trade' aka 'Frankatur'.
     *
     * The attribute is exclusively used for the product Europaket (V54EPAK).
     * DDU is deprecated (use DAP instead).
     *
     * @var string|null
     */
    private ?string $shippingConditions;

    /**
     * Invoice number.
     *
     * @var string|null
     */
    private ?string $invoiceNo;

    /**
     * Permit number. Very rarely needed. Mostly relevant for higher value goods.
     *
     * An example use case would be an item made from crocodile leather
     * which requires dedicated license / permit identified by that number.
     *
     * @var string|null
     */
    private ?string $permitNo;

    /**
     * Attest or certification identified by this number. Very rarely needed.
     *
     * An example use case would be a medical shipment referring to
     * an attestation that a certain amount of medicine may be imported
     * within e.g. the current quarter of the year.
     *
     * @var string|null
     */
    private ?string $attestationNo;

    /**
     * Location at which the shipment is handed over to DHL.
     *
     * @var string|null
     */
    private ?string $officeOfOrigin;

    /**
     * The customs reference is used by customs authorities to identify
     * economics operators an/or other persons involved. With the given
     * reference, granted authorizations and/or relevant processes in
     * customs clearance an/or taxation can be taken into account.
     * Aka Zoll-Nummer or EORI-Number but dependent on destination.
     *
     * @var string|null
     */
    private ?string $shipperCustomsRef;

    /**
     * The customs reference is used by customs authorities to identify
     * economics operators an/or other persons involved. With the given
     * reference, granted authorizations and/or relevant processes in
     * customs clearance an/or taxation can be taken into account.
     * Aka Zoll-Nummer or EORI-Number but dependent on destination.
     *
     * @var string|null
     */
    private ?string $consigneeCustomsRef;

    /**
     * Flag confirming whether electronic record for export was made.
     *
     * @var bool|null
     */
    private ?bool $hasElectronicExportNotification;

    /**
     * @param \JsonSerializable[]|CustomsItem[] $items Commodity types in that package
     * @param string $exportType Category of goods contained in parcel
     */
    public function __construct(private readonly array $items, private readonly string $exportType)
    {
    }

    public function setExportDescription(?string $exportDescription): void
    {
        $this->exportDescription = $exportDescription;
    }

    public function setPostalCharges(\JsonSerializable|MonetaryValue|null $postalCharges): void
    {
        $this->postalCharges = $postalCharges;
    }

    public function setShippingConditions(?string $shippingConditions): void
    {
        $this->shippingConditions = $shippingConditions;
    }

    public function setInvoiceNo(?string $invoiceNo): void
    {
        $this->invoiceNo = $invoiceNo;
    }

    public function setPermitNo(?string $permitNo): void
    {
        $this->permitNo = $permitNo;
    }

    public function setAttestationNo(?string $attestationNo): void
    {
        $this->attestationNo = $attestationNo;
    }

    public function setOfficeOfOrigin(?string $officeOfOrigin): void
    {
        $this->officeOfOrigin = $officeOfOrigin;
    }

    public function setShipperCustomsRef(?string $shipperCustomsRef): void
    {
        $this->shipperCustomsRef = $shipperCustomsRef;
    }

    public function setConsigneeCustomsRef(?string $consigneeCustomsRef): void
    {
        $this->consigneeCustomsRef = $consigneeCustomsRef;
    }

    public function setHasElectronicExportNotification(?bool $hasElectronicExportNotification): void
    {
        $this->hasElectronicExportNotification = $hasElectronicExportNotification;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return mixed[] Serializable object properties
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
