<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class Services implements \JsonSerializable
{
    /**
     * Preferred neighbour.
     *
     * @var string|null
     */
    private ?string $preferredNeighbour;

    /**
     * Preferred location.
     *
     * @var string|null
     */
    private ?string $preferredLocation;

    /**
     * Preferred day of delivery in format YYYY-MM-DD.
     *
     * Shipper can request a preferred day of delivery. The preferred day
     * should be between 2 and 6 working days after handover to DHL.
     *
     * @var string|null
     */
    private ?string $preferredDay;

    /**
     * Trigger checking the age of recipient.
     *
     * Allowed values:
     * - A16
     * - A18
     *
     * @var string|null
     */
    private ?string $visualCheckOfAge;

    /**
     * Delivery can only be signed for by yourself personally.
     *
     * @var bool|null
     */
    private ?bool $namedPersonOnly;

    /**
     * Instructions and endorsement how to treat international undeliverable shipment.
     *
     * By default, shipments are returned if undeliverable. There are country specific
     * rules whether the shipment is returned immediately or after a grace period.
     *
     * Allowed values:
     * - RETURN
     * - ABANDON
     *
     * @var string|null
     */
    private ?string $endorsement;

    /**
     * Delivery can only be signed for by yourself personally or by members of your household.
     *
     * @var bool|null
     */
    private ?bool $noNeighbourDelivery;

    /**
     * Special instructions for delivery.
     *
     * 2 character code, possible values agreed in contract.
     *
     * @var string|null
     */
    private ?string $individualSenderRequirement;

    /**
     * Undeliverable domestic shipment can be forwarded and held at retail.
     *
     * Notification to email (fallback: consignee email) will be used.
     *
     * @var string|null
     */
    private ?string $parcelOutletRouting;

    /**
     * Choice of premium vs economy parcel.
     *
     * Availability is country dependent and may be manipulated by DHL
     * if choice is not available. Please review the label.
     *
     * @var bool|null
     */
    private ?bool $premium;

    /**
     * Closest Drop-Point Delivery
     *
     * Delivery to the drop-point closest to the address of the recipient of the
     * shipment. For this kind of delivery either the phone number and/or the
     * e-mail address of the receiver is mandatory. For shipments using DHL Paket
     * International it is recommended that you choose one of the three delivery types:
     * Economy, Premium, CDP. Otherwise, the current default for the receiver country will be picked.
     *
     * @var bool|null
     */
    private ?bool $closestDropPoint;

    /**
     * Sperrgut.
     *
     * @var bool|null
     */
    private ?bool $bulkyGoods;

    /**
     * PDDP: Deutsche Post and sender handle import duties instead of consignee. Duties are paid by the shipper.
     *
     * @var bool|null
     */
    private ?bool $postalDeliveryDutyPaid;

    /**
     * Service for package return. Requires also DHL Retoure to be set.
     *
     * @var bool|null
     */
    private ?bool $packagingReturn;

    /**
     * Delivery must be signed for by the recipient and not by DHL staff
     *
     * @var bool|null
     */
    private ?bool $signedForByRecipient;

    /**
     * An email notification to the recipient that the shipment is closed (manifested).
     *
     * The notification can be sent to multiple recipient email addresses.
     * This service is about to be deprecated.
     *
     * @var \JsonSerializable|ShippingConfirmation|null
     */
    private \JsonSerializable|ShippingConfirmation|null $shippingConfirmation;

    /**
     * Requests return label (aka 'retoure') to be provided.
     *
     * Also requires returnAddress and return billing number. Neither weight
     * nor dimension need to be specified for the retoure (flat rate service).
     *
     * @var \JsonSerializable|DhlRetoure|null
     */
    private \JsonSerializable|DhlRetoure|null $dhlRetoure;

    /**
     * Cash on delivery (Nachnahme).
     *
     * Currency must be Euro. Either bank account information or
     * account reference (from customer profile) must be provided.
     * Transfernote1 + 2 are references transmitted during bank transfer.
     * Providing account information explicitly requires elevated privileges.
     *
     * @var \JsonSerializable|CashOnDelivery|null
     */
    private \JsonSerializable|CashOnDelivery|null $cashOnDelivery;

    /**
     * Currency and numeric value.
     *
     * @var \JsonSerializable|MonetaryValue|null
     */
    private \JsonSerializable|MonetaryValue|null $additionalInsurance;

    /**
     * Check the identity of the recipient. name (Firstname, lastname), dob or age.
     *
     * This uses firstName and lastName as separate attributes
     * since for identity check an automatic split of a one-line name
     * is not considered reliable enough.
     *
     * @var \JsonSerializable|IdentCheck|null
     */
    private \JsonSerializable|IdentCheck|null $identCheck;

    public function setPreferredNeighbour(?string $preferredNeighbour): void
    {
        $this->preferredNeighbour = $preferredNeighbour;
    }

    public function setPreferredLocation(?string $preferredLocation): void
    {
        $this->preferredLocation = $preferredLocation;
    }

    public function setPreferredDay(?string $preferredDay): void
    {
        $this->preferredDay = $preferredDay;
    }

    public function setVisualCheckOfAge(?string $visualCheckOfAge): void
    {
        $this->visualCheckOfAge = $visualCheckOfAge;
    }

    public function setNamedPersonOnly(?bool $namedPersonOnly): void
    {
        $this->namedPersonOnly = $namedPersonOnly;
    }

    public function setEndorsement(?string $endorsement): void
    {
        $this->endorsement = $endorsement;
    }

    public function setNoNeighbourDelivery(?bool $noNeighbourDelivery): void
    {
        $this->noNeighbourDelivery = $noNeighbourDelivery;
    }

    public function setIndividualSenderRequirement(?string $individualSenderRequirement): void
    {
        $this->individualSenderRequirement = $individualSenderRequirement;
    }

    public function setParcelOutletRouting(?string $parcelOutletRouting): void
    {
        $this->parcelOutletRouting = $parcelOutletRouting;
    }

    public function setPremium(?bool $premium): void
    {
        $this->premium = $premium;
    }

    public function setClosestDropPoint(?bool $closestDropPoint): void
    {
        $this->closestDropPoint = $closestDropPoint;
    }

    public function setBulkyGoods(?bool $bulkyGoods): void
    {
        $this->bulkyGoods = $bulkyGoods;
    }

    public function setPostalDeliveryDutyPaid(?bool $postalDeliveryDutyPaid): void
    {
        $this->postalDeliveryDutyPaid = $postalDeliveryDutyPaid;
    }

    public function setPackagingReturn(?bool $packagingReturn): void
    {
        $this->packagingReturn = $packagingReturn;
    }

    public function setSignedForByRecipient(?bool $signedForByRecipient): void
    {
        $this->signedForByRecipient = $signedForByRecipient;
    }

    public function setShippingConfirmation(\JsonSerializable|ShippingConfirmation|null $shippingConfirmation): void
    {
        $this->shippingConfirmation = $shippingConfirmation;
    }

    public function setDhlRetoure(\JsonSerializable|DhlRetoure|null $dhlRetoure): void
    {
        $this->dhlRetoure = $dhlRetoure;
    }

    public function setCashOnDelivery(\JsonSerializable|CashOnDelivery|null $cashOnDelivery): void
    {
        $this->cashOnDelivery = $cashOnDelivery;
    }

    public function setAdditionalInsurance(\JsonSerializable|MonetaryValue|null $additionalInsurance): void
    {
        $this->additionalInsurance = $additionalInsurance;
    }

    public function setIdentCheck(\JsonSerializable|IdentCheck|null $identCheck): void
    {
        $this->identCheck = $identCheck;
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
