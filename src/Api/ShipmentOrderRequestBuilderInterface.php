<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Api;

use Dhl\Sdk\ParcelDe\Shipping\Exception\RequestValidatorException;

/**
 * @api
 */
interface ShipmentOrderRequestBuilderInterface
{
    public const REQUEST_TYPE_SOAP = 'SOAP';
    public const REQUEST_TYPE_REST = 'REST';

    public const ENDORSEMENT_TYPE_IMMEDIATE = 'IMMEDIATE';
    public const ENDORSEMENT_TYPE_ABANDONMENT = 'ABANDONMENT';

    public const AGE_TYPE_16 = 'A16';
    public const AGE_TYPE_18 = 'A18';

    public const DELIVERY_TYPE_ECONOMY = 'ECONOMY';
    public const DELIVERY_TYPE_PREMIUM = 'PREMIUM';
    public const DELIVERY_TYPE_CDP = 'CDP';

    public const EXPORT_TYPE_OTHER = 'OTHER';
    public const EXPORT_TYPE_PRESENT = 'PRESENT';
    public const EXPORT_TYPE_COMMERCIAL_SAMPLE = 'COMMERCIAL_SAMPLE';
    public const EXPORT_TYPE_DOCUMENT = 'DOCUMENT';
    public const EXPORT_TYPE_RETURN_OF_GOODS = 'RETURN_OF_GOODS';
    public const EXPORT_TYPE_COMMERCIAL_GOODS = 'COMMERCIAL_GOODS';

    public const INCOTERM_CODE_DDP = 'DDP';
    public const INCOTERM_CODE_DXV = 'DXV';
    public const INCOTERM_CODE_DAP = 'DAP';
    public const INCOTERM_CODE_DDX = 'DDX';
    public const INCOTERM_CODE_CPT = 'CPT';

    public const MSG_MISSING_SHIPPER = 'No sender included with shipment order.';
    public const MSG_MISSING_RECIPIENT = 'No recipient included with shipment order.';
    public const MSG_MISSING_CONTACT = 'Either recipient email or post number must be set for Postfiliale delivery.';
    public const MSG_SERVICE_UNSUPPORTED = 'The service "%s" is not supported.';

    public function setSequenceNumber(string $sequenceNumber): ShipmentOrderRequestBuilderInterface;

    /**
     * Set shipper account (required).
     *
     * @param string|null $returnBillingNumber Provide if return label should be included with response.
     */
    public function setShipperAccount(
        string $billingNumber,
        string $returnBillingNumber = null
    ): ShipmentOrderRequestBuilderInterface;

    /**
     * Set shipper address (optional).
     *
     * The shipper address is already stored in GKP but may be overridden if necessary.
     *
     * @see setShipperReference
     *
     * @param string|null $name
     * @param string|null $nameAddition
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $contactPerson
     * @param string|null $state
     * @param string|null $dispatchingInformation
     * @param string[] $addressAddition
     */
    public function setShipperAddress(
        string $company,
        string $countryCode,
        string $postalCode,
        string $city,
        string $streetName,
        string $streetNumber = '',
        string $name = null,
        string $nameAddition = null,
        string $email = null,
        string $phone = null,
        string $contactPerson = null,
        string $state = null,
        string $dispatchingInformation = null,
        array $addressAddition = []
    ): ShipmentOrderRequestBuilderInterface;

    /**
     * Overwrite bank account defaults (configured in Business Customer Portal).
     *
     * If no default bank data is configured in the portal, then these fields
     * are required for COD payments.
     * If defaults are configured in the portal, then only the individual notes
     * (reason for payment) fields may be set per shipment order.
     *
     * @param string|null $accountOwner
     * @param string|null $bankName
     * @param string|null $iban
     * @param string|null $bic
     * @param string|null $accountReference
     * @param string[] $notes
     */
    public function setShipperBankData(
        string $accountOwner = null,
        string $bankName = null,
        string $iban = null,
        string $bic = null,
        string $accountReference = null,
        array $notes = []
    ): ShipmentOrderRequestBuilderInterface;

    /**
     * Set return address (optional).
     *
     * Return address will be discarded if no return billing number is given.
     *
     * @param string|null $name
     * @param string|null $nameAddition
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $contactPerson
     * @param string|null $state
     * @param string|null $dispatchingInformation
     * @param string[] $addressAddition
     */
    public function setReturnAddress(
        string $company,
        string $countryCode,
        string $postalCode,
        string $city,
        string $streetName,
        string $streetNumber = '',
        string $name = null,
        string $nameAddition = null,
        string $email = null,
        string $phone = null,
        string $contactPerson = null,
        string $state = null,
        string $dispatchingInformation = null,
        array $addressAddition = []
    ): ShipmentOrderRequestBuilderInterface;

    /**
     * Set consignee address for a shipment (required).
     *
     * @param string|null $company
     * @param string|null $nameAddition
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $contactPerson
     * @param string|null $state
     * @param string|null $dispatchingInformation
     * @param string[] $addressAddition
     */
    public function setRecipientAddress(
        string $name,
        string $countryCode,
        string $postalCode,
        string $city,
        string $streetName,
        string $streetNumber = '',
        string $company = null,
        string $nameAddition = null,
        string $email = null,
        string $phone = null,
        string $contactPerson = null,
        string $state = null,
        string $dispatchingInformation = null,
        array $addressAddition = []
    ): ShipmentOrderRequestBuilderInterface;

    /**
     * Set shipment details (required).
     *
     * Possible product code values:
     * - V01PAK
     * - V53WPAK
     * - V54EPAK
     * - V06PAK
     * - V06TG
     * - V06WZ
     * - V86PARCEL
     * - V87PARCEL
     * - V82PARCEL
     *
     * @param string $productCode Product to be ordered.
     * @param \DateTimeInterface $shipmentDate.
     * @param string|null $shipmentReference
     * @param string|null $returnReference
     * @param string|null $costCentre
     */
    public function setShipmentDetails(
        string $productCode,
        \DateTimeInterface $shipmentDate,
        string $shipmentReference = null,
        string $returnReference = null,
        string $costCentre = null
    ): ShipmentOrderRequestBuilderInterface;

    /**
     * Set package details.
     *
     * @param float $weightInKg Weight in KG, two digits after the decimal point
     */
    public function setPackageDetails(float $weightInKg): ShipmentOrderRequestBuilderInterface;

    /**
     * Set the amount the package should be insured with. Omit if standard amount is sufficient.
     */
    public function setInsuredValue(float $insuredValue): ShipmentOrderRequestBuilderInterface;

    /**
     * Set COD amount (optional).
     *
     * @param float $codAmount Money amount to be collected.
     */
    public function setCodAmount(float $codAmount): ShipmentOrderRequestBuilderInterface;

    /**
     * Set package dimensions.
     *
     * @param int $width Width in cm
     * @param int $length Length in cm
     * @param int $height Height in cm
     */
    public function setPackageDimensions(
        int $width,
        int $length,
        int $height
    ): ShipmentOrderRequestBuilderInterface;

    /**
     * Choose Packstation delivery.
     *
     * Post number of the receiver is required.
     *
     * @param string|null $state
     * @param string|null $country
     */
    public function setPackstation(
        string $recipientName,
        string $recipientPostNumber,
        string $packstationNumber,
        string $countryCode,
        string $postalCode,
        string $city,
        string $state = null,
        string $country = null
    ): ShipmentOrderRequestBuilderInterface;

    /**
     * Choose Postfiliale delivery.
     *
     * Post number of the receiver may be omitted.
     *
     * @todo(nr): DHLGW-1355 add email argument
     *
     * @param string|null $postNumber If not set, receiver email will be used.
     * @param string|null $state
     * @param string|null $country
     */
    public function setPostfiliale(
        string $recipientName,
        string $postfilialNumber,
        string $countryCode,
        string $postalCode,
        string $city,
        string $postNumber = null,
        string $state = null,
        string $country = null
    ): ShipmentOrderRequestBuilderInterface;

    /**
     * Choose P.O. Box (Postfach) delivery
     *
     * @param string $poBoxNumber 6-digit numeric value, no whitespace
     */
    public function setPOBox(
        string $recipientName,
        string $poBoxNumber,
        string $countryCode,
        string $postalCode,
        string $city
    ): ShipmentOrderRequestBuilderInterface;

    /**
     * Set reference to the shipper data configured in business customer portal (optional).
     *
     * If not given, set address details.
     *
     * @see setShipperAddress
     */
    public function setShipperReference(string $reference): ShipmentOrderRequestBuilderInterface;

    /**
     * Book "Day of Delivery" service (V06TG and V06WZ only).
     */
    public function setDayOfDelivery(string $cetDate): ShipmentOrderRequestBuilderInterface;

    /**
     * Book "Delivery Time Frame" service (V06TG and V06WZ only).
     */
    public function setDeliveryTimeFrame(string $timeFrameType): ShipmentOrderRequestBuilderInterface;

    /**
     * Book "Preferred Day" service.
     */
    public function setPreferredDay(string $cetDate): ShipmentOrderRequestBuilderInterface;

    /**
     * Book "Preferred Location" service.
     */
    public function setPreferredLocation(string $location): ShipmentOrderRequestBuilderInterface;

    /**
     * Book "Preferred Neighbour" service.
     */
    public function setPreferredNeighbour(string $neighbour): ShipmentOrderRequestBuilderInterface;

    /**
     * Add individual details for handling (free text).
     */
    public function setIndividualSenderRequirement(string $handlingDetails): ShipmentOrderRequestBuilderInterface;

    /**
     * Book service of immediate shipment return in case of non-successful delivery (V06PA only).
     */
    public function setReturnImmediately(): ShipmentOrderRequestBuilderInterface;

    /**
     * Book service notice in case of non-deliverability.
     */
    public function setNoticeOfNonDeliverability(): ShipmentOrderRequestBuilderInterface;

    /**
     * Specify how DHL should handle the shipment if recipient is not met.
     *
     * Possible values:
     * - IMMEDIATE
     * - ABANDONMENT
     *
     * @see ShipmentOrderRequestBuilderInterface::ENDORSEMENT_TYPE_IMMEDIATE
     * @see ShipmentOrderRequestBuilderInterface::ENDORSEMENT_TYPE_ABANDONMENT
     */
    public function setShipmentEndorsementType(string $endorsementType): ShipmentOrderRequestBuilderInterface;

    /**
     * Book "Visual Age Check" service.
     *
     * Possible values:
     * - A16
     * - A18
     *
     * @see ShipmentOrderRequestBuilderInterface::AGE_TYPE_16
     * @see ShipmentOrderRequestBuilderInterface::AGE_TYPE_18
     */
    public function setVisualCheckOfAge(string $ageType): ShipmentOrderRequestBuilderInterface;

    /**
     * Prohibit delivery to neighbours.
     */
    public function setNoNeighbourDelivery(): ShipmentOrderRequestBuilderInterface;

    /**
     * Book "Named Person Only" service.
     */
    public function setNamedPersonOnly(): ShipmentOrderRequestBuilderInterface;

    /**
     * Book "Return Receipt" service.
     */
    public function setReturnReceipt(): ShipmentOrderRequestBuilderInterface;

    /**
     * Choose a delivery type.
     *
     * @see ShipmentOrderRequestBuilderInterface::DELIVERY_TYPE_ECONOMY
     * @see ShipmentOrderRequestBuilderInterface::DELIVERY_TYPE_PREMIUM
     * @see ShipmentOrderRequestBuilderInterface::DELIVERY_TYPE_CDP
     */
    public function setDeliveryType(string $deliveryType): ShipmentOrderRequestBuilderInterface;

    /**
     * Indicate shipment containing bulky goods.
     */
    public function setBulkyGoods(): ShipmentOrderRequestBuilderInterface;

    /**
     * Book "Ident Check" service.
     *
     * @see ShipmentOrderRequestBuilderInterface::AGE_TYPE_16
     * @see ShipmentOrderRequestBuilderInterface::AGE_TYPE_18
     */
    public function setIdentCheck(
        string $lastName,
        string $firstName,
        string $dateOfBirth,
        string $minimumAge
    ): ShipmentOrderRequestBuilderInterface;

    /**
     * Book "Parcel Outlet Routing" service.
     *
     * @param string|null $email If not set, receiver email will be used.
     */
    public function setParcelOutletRouting(string $email = null): ShipmentOrderRequestBuilderInterface;

    /**
     * Book the "Postal Delivery Duty Paid" (PDDP) service.
     */
    public function setDeliveryDutyPaid(): ShipmentOrderRequestBuilderInterface;

    /**
     * Book the "Signed For By Recipient" service.
     */
    public function setSignedForByRecipient(): ShipmentOrderRequestBuilderInterface;

    /**
     * Set customs details for international shipments.
     *
     * @see ShipmentOrderRequestBuilderInterface::EXPORT_TYPE_OTHER
     * @see ShipmentOrderRequestBuilderInterface::EXPORT_TYPE_PRESENT
     * @see ShipmentOrderRequestBuilderInterface::EXPORT_TYPE_COMMERCIAL_SAMPLE
     * @see ShipmentOrderRequestBuilderInterface::EXPORT_TYPE_DOCUMENT
     * @see ShipmentOrderRequestBuilderInterface::EXPORT_TYPE_RETURN_OF_GOODS
     * @see ShipmentOrderRequestBuilderInterface::EXPORT_TYPE_COMMERCIAL_GOODS
     *
     * @see ShipmentOrderRequestBuilderInterface::INCOTERM_CODE_DDP
     * @see ShipmentOrderRequestBuilderInterface::INCOTERM_CODE_DXV
     * @see ShipmentOrderRequestBuilderInterface::INCOTERM_CODE_DAP
     * @see ShipmentOrderRequestBuilderInterface::INCOTERM_CODE_DDX
     * @see ShipmentOrderRequestBuilderInterface::INCOTERM_CODE_CPT
     *
     * @param string|null $exportTypeDescription
     * @param string|null $termsOfTrade
     * @param string|null $invoiceNumber
     * @param string|null $permitNumber
     * @param string|null $attestationNumber
     * @param bool|null $electronicExportNotification
     * @param string|null $sendersCustomsReference
     * @param string|null $addresseesCustomsReference
     */
    public function setCustomsDetails(
        string $exportType,
        string $placeOfCommital,
        float $additionalFee,
        string $exportTypeDescription = null,
        string $termsOfTrade = null,
        string $invoiceNumber = null,
        string $permitNumber = null,
        string $attestationNumber = null,
        bool $electronicExportNotification = null,
        string $sendersCustomsReference = null,
        string $addresseesCustomsReference = null
    ): ShipmentOrderRequestBuilderInterface;

    /**
     * Add a package item's customs details (optional).
     *
     * @param float $value Customs value in EUR
     * @param float $weight Weight in kg, two digits after the decimal point
     */
    public function addExportItem(
        int $qty,
        string $description,
        float $value,
        float $weight,
        string $hsCode,
        string $countryOfOrigin
    ): ShipmentOrderRequestBuilderInterface;

    /**
     * Create the shipment request and reset the builder data.
     *
     * @throws RequestValidatorException
     */
    public function create(): object;
}
