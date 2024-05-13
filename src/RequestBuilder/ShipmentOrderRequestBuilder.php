<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\RequestBuilder;

use Dhl\Sdk\ParcelDe\Shipping\Api\ShipmentOrderRequestBuilderInterface;
use Dhl\Sdk\ParcelDe\Shipping\Exception\RequestValidatorException;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\BankAccount;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\CashOnDelivery;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\ContactAddress;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\Customs;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\CustomsItem;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\Details;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\DhlRetoure;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\Dimension;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\IdentCheck;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\Locker;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\MonetaryValue;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\POBox;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\PostOffice;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\ReturnAddress;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\Services;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\Shipment;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\ShipperAddress;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\ShipperAddressRef;
use Dhl\Sdk\ParcelDe\Shipping\Model\RequestType\Weight;

class ShipmentOrderRequestBuilder implements ShipmentOrderRequestBuilderInterface
{
    /**
     * The collected data used to build the request
     *
     * @var mixed[]
     */
    private array $data = [];

    public function setRequestIndex(int $requestIndex): ShipmentOrderRequestBuilderInterface
    {
        $this->data['requestIndex'] = $requestIndex;

        return $this;
    }

    public function setShipperAccount(
        string $billingNumber,
        string $returnBillingNumber = null
    ): ShipmentOrderRequestBuilderInterface {
        $this->data['shipper']['billingNumber'] = $billingNumber;
        $this->data['shipper']['returnBillingNumber'] = $returnBillingNumber;

        return $this;
    }

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
    ): ShipmentOrderRequestBuilderInterface {
        $this->data['shipper']['address']['company'] = $company;
        $this->data['shipper']['address']['countryCode'] = $countryCode;
        $this->data['shipper']['address']['postalCode'] = $postalCode;
        $this->data['shipper']['address']['city'] = $city;
        $this->data['shipper']['address']['streetName'] = $streetName;
        $this->data['shipper']['address']['streetNumber'] = $streetNumber;
        $this->data['shipper']['address']['name'] = $name;
        $this->data['shipper']['address']['nameAddition'] = $nameAddition;
        $this->data['shipper']['address']['email'] = $email;
        $this->data['shipper']['address']['phone'] = $phone;
        $this->data['shipper']['address']['contactPerson'] = $contactPerson;
        $this->data['shipper']['address']['state'] = $state;
        $this->data['shipper']['address']['dispatchingInformation'] = $dispatchingInformation;
        $this->data['shipper']['address']['addressAddition'] = $addressAddition;

        return $this;
    }

    public function setShipperBankData(
        string $accountOwner = null,
        string $bankName = null,
        string $iban = null,
        string $bic = null,
        string $accountReference = null,
        array $notes = []
    ): ShipmentOrderRequestBuilderInterface {
        $this->data['shipper']['bankData']['owner'] = $accountOwner;
        $this->data['shipper']['bankData']['bankName'] = $bankName;
        $this->data['shipper']['bankData']['iban'] = $iban;
        $this->data['shipper']['bankData']['bic'] = $bic;
        $this->data['shipper']['bankData']['accountReference'] = $accountReference;
        $this->data['shipper']['bankData']['notes'] = $notes;

        return $this;
    }

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
    ): ShipmentOrderRequestBuilderInterface {
        $this->data['return']['address']['company'] = $company;
        $this->data['return']['address']['countryCode'] = $countryCode;
        $this->data['return']['address']['postalCode'] = $postalCode;
        $this->data['return']['address']['city'] = $city;
        $this->data['return']['address']['streetName'] = $streetName;
        $this->data['return']['address']['streetNumber'] = $streetNumber;
        $this->data['return']['address']['name'] = $name;
        $this->data['return']['address']['nameAddition'] = $nameAddition;
        $this->data['return']['address']['email'] = $email;
        $this->data['return']['address']['phone'] = $phone;
        $this->data['return']['address']['contactPerson'] = $contactPerson;
        $this->data['return']['address']['state'] = $state;
        $this->data['return']['address']['dispatchingInformation'] = $dispatchingInformation;
        $this->data['return']['address']['addressAddition'] = $addressAddition;

        return $this;
    }

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
    ): ShipmentOrderRequestBuilderInterface {
        $this->data['recipient']['address']['name'] = $name;
        $this->data['recipient']['address']['countryCode'] = $countryCode;
        $this->data['recipient']['address']['postalCode'] = $postalCode;
        $this->data['recipient']['address']['city'] = $city;
        $this->data['recipient']['address']['streetName'] = $streetName;
        $this->data['recipient']['address']['streetNumber'] = $streetNumber;
        $this->data['recipient']['address']['company'] = $company;
        $this->data['recipient']['address']['nameAddition'] = $nameAddition;
        $this->data['recipient']['address']['email'] = $email;
        $this->data['recipient']['address']['phone'] = $phone;
        $this->data['recipient']['address']['contactPerson'] = $contactPerson;
        $this->data['recipient']['address']['state'] = $state;
        $this->data['recipient']['address']['dispatchingInformation'] = $dispatchingInformation;
        $this->data['recipient']['address']['addressAddition'] = $addressAddition;

        return $this;
    }

    public function setShipmentDetails(
        string $productCode,
        \DateTimeInterface $shipmentDate,
        string $shipmentReference = null,
        string $returnReference = null,
        string $costCentre = null
    ): ShipmentOrderRequestBuilderInterface {
        $timezone = new \DateTimeZone('Europe/Berlin');

        if ($shipmentDate instanceof \DateTime) {
            $shipmentDate = \DateTimeImmutable::createFromMutable($shipmentDate);
            $shipmentDate = $shipmentDate->setTimezone($timezone);
        } elseif ($shipmentDate instanceof \DateTimeImmutable) {
            $shipmentDate = $shipmentDate->setTimezone($timezone);
        }

        $this->data['shipmentDetails']['product'] = $productCode;
        $this->data['shipmentDetails']['date'] = $shipmentDate->format('Y-m-d');
        $this->data['shipmentDetails']['shipmentReference'] = $shipmentReference;
        $this->data['shipmentDetails']['returnReference'] = $returnReference;
        $this->data['shipmentDetails']['costCentre'] = $costCentre;

        return $this;
    }

    public function setPackageDetails(float $weightInKg): ShipmentOrderRequestBuilderInterface
    {
        $this->data['packageDetails']['weight'] = $weightInKg;

        return $this;
    }

    public function setPackageDimensions(int $width, int $length, int $height): ShipmentOrderRequestBuilderInterface
    {
        $this->data['packageDetails']['dimensions']['width'] = $width;
        $this->data['packageDetails']['dimensions']['length'] = $length;
        $this->data['packageDetails']['dimensions']['height'] = $height;

        return $this;
    }

    public function setInsuredValue(float $insuredValue): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['insuredValue'] = $insuredValue;

        return $this;
    }

    public function setCodAmount(float $codAmount): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['cod']['codAmount'] = $codAmount;

        return $this;
    }

    public function setPackstation(
        string $recipientName,
        string $recipientPostNumber,
        string $packstationNumber,
        string $countryCode,
        string $postalCode,
        string $city,
        string $state = null,
        string $country = null
    ): ShipmentOrderRequestBuilderInterface {
        $this->data['recipient']['address']['name'] = $recipientName;
        $this->data['recipient']['packstation']['postNumber'] = $recipientPostNumber;
        $this->data['recipient']['packstation']['number'] = $packstationNumber;
        $this->data['recipient']['packstation']['countryCode'] = $countryCode;
        $this->data['recipient']['packstation']['postalCode'] = $postalCode;
        $this->data['recipient']['packstation']['city'] = $city;
        $this->data['recipient']['packstation']['state'] = $state;
        $this->data['recipient']['packstation']['country'] = $country;

        return $this;
    }

    public function setPostfiliale(
        string $recipientName,
        string $postfilialNumber,
        string $countryCode,
        string $postalCode,
        string $city,
        string $postNumber = null,
        string $state = null,
        string $country = null
    ): ShipmentOrderRequestBuilderInterface {
        $this->data['recipient']['address']['name'] = $recipientName;
        $this->data['recipient']['postfiliale']['number'] = $postfilialNumber;
        $this->data['recipient']['postfiliale']['countryCode'] = $countryCode;
        $this->data['recipient']['postfiliale']['postalCode'] = $postalCode;
        $this->data['recipient']['postfiliale']['city'] = $city;
        $this->data['recipient']['postfiliale']['postNumber'] = $postNumber;
        $this->data['recipient']['postfiliale']['state'] = $state;
        $this->data['recipient']['postfiliale']['country'] = $country;

        return $this;
    }

    public function setPOBox(
        string $recipientName,
        string $poBoxNumber,
        string $countryCode,
        string $postalCode,
        string $city
    ): ShipmentOrderRequestBuilderInterface {
        $this->data['recipient']['address']['name'] = $recipientName;
        $this->data['recipient']['pobox']['number'] = $poBoxNumber;
        $this->data['recipient']['pobox']['countryCode'] = $countryCode;
        $this->data['recipient']['pobox']['postalCode'] = $postalCode;
        $this->data['recipient']['pobox']['city'] = $city;

        return $this;
    }

    public function setShipperReference(string $reference): ShipmentOrderRequestBuilderInterface
    {
        $this->data['shipper']['reference'] = $reference;

        return $this;
    }

    public function setDayOfDelivery(string $cetDate): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['dayOfDelivery'] = $cetDate;

        return $this;
    }

    public function setDeliveryTimeFrame(string $timeFrameType): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['deliveryTimeFrame'] = $timeFrameType;

        return $this;
    }

    public function setPreferredDay(string $cetDate): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['preferredDay'] = $cetDate;

        return $this;
    }

    public function setPreferredLocation(string $location): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['preferredLocation'] = $location;

        return $this;
    }

    public function setPreferredNeighbour(string $neighbour): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['preferredNeighbour'] = $neighbour;

        return $this;
    }

    public function setIndividualSenderRequirement(string $handlingDetails): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['individualSenderRequirement'] = $handlingDetails;

        return $this;
    }

    public function setReturnImmediately(): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['returnImmediately'] = true;

        return $this;
    }

    public function setNoticeOfNonDeliverability(): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['noticeOfNonDeliverability'] = true;

        return $this;
    }

    public function setShipmentEndorsementType(string $endorsementType): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['endorsement'] = $endorsementType;

        return $this;
    }

    public function setVisualCheckOfAge(string $ageType): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['visualCheckOfAge'] = $ageType;

        return $this;
    }

    public function setNoNeighbourDelivery(): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['noNeighbourDelivery'] = true;

        return $this;
    }

    public function setNamedPersonOnly(): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['namedPersonOnly'] = true;

        return $this;
    }

    public function setReturnReceipt(): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['returnReceipt'] = true;

        return $this;
    }

    public function setDeliveryType(string $deliveryType): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['deliveryType'] = $deliveryType;

        return $this;
    }

    public function setBulkyGoods(): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['bulkyGoods'] = true;

        return $this;
    }

    public function setIdentCheck(
        string $lastName,
        string $firstName,
        string $dateOfBirth,
        string $minimumAge
    ): ShipmentOrderRequestBuilderInterface {
        $this->data['services']['identCheck']['surname'] = $lastName;
        $this->data['services']['identCheck']['givenName'] = $firstName;
        $this->data['services']['identCheck']['dateOfBirth'] = $dateOfBirth;
        $this->data['services']['identCheck']['minimumAge'] = $minimumAge;

        return $this;
    }

    public function setParcelOutletRouting(string $email = null): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['parcelOutletRouting']['active'] = true;
        $this->data['services']['parcelOutletRouting']['details'] = $email;

        return $this;
    }

    public function setDeliveryDutyPaid(): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['pddp'] = true;

        return $this;
    }

    public function setSignedForByRecipient(): ShipmentOrderRequestBuilderInterface
    {
        $this->data['services']['signedForByRecipient'] = true;

        return $this;
    }

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
    ): ShipmentOrderRequestBuilderInterface {
        if (!isset($this->data['customsDetails']['items'])) {
            $this->data['customsDetails']['items'] = [];
        }

        $this->data['customsDetails']['exportType'] = $exportType;
        $this->data['customsDetails']['exportTypeDescription'] = $exportTypeDescription;
        $this->data['customsDetails']['placeOfCommital'] = $placeOfCommital;
        $this->data['customsDetails']['additionalFee'] = $additionalFee;
        $this->data['customsDetails']['termsOfTrade'] = $termsOfTrade;
        $this->data['customsDetails']['invoiceNumber'] = $invoiceNumber;
        $this->data['customsDetails']['permitNumber'] = $permitNumber;
        $this->data['customsDetails']['attestationNumber'] = $attestationNumber;
        $this->data['customsDetails']['electronicExportNotification'] = $electronicExportNotification;
        $this->data['customsDetails']['sendersCustomsReference'] = $sendersCustomsReference;
        $this->data['customsDetails']['addresseesCustomsReference'] = $addresseesCustomsReference;

        return $this;
    }

    public function addExportItem(
        int $qty,
        string $description,
        float $value,
        float $weight,
        string $hsCode,
        string $countryOfOrigin
    ): ShipmentOrderRequestBuilderInterface {
        if (!isset($this->data['customsDetails']['items'])) {
            $this->data['customsDetails']['items'] = [];
        }

        $this->data['customsDetails']['items'][] = [
            'qty' => $qty,
            'description' => $description,
            'weight' => $weight,
            'value' => $value,
            'hsCode' => $hsCode,
            'countryOfOrigin' => $countryOfOrigin,
        ];

        return $this;
    }

    public function create(): object
    {
        if (!isset($this->data['shipper']['reference']) && !isset($this->data['shipper']['address'])) {
            throw new RequestValidatorException(ShipmentOrderRequestBuilderInterface::MSG_MISSING_SHIPPER);
        }

        if (isset($this->data['shipper']['address'])) {
            $addressData = $this->data['shipper']['address'];
            $shipper = new ShipperAddress(
                $addressData['company'],
                $addressData['streetName'],
                $addressData['postalCode'],
                $addressData['city'],
                $addressData['countryCode']
            );
            $shipper->setAddressHouse($addressData['streetNumber']);
            $shipper->setName2($addressData['name']);
            $shipper->setName3($addressData['nameAddition']);
            $shipper->setState($addressData['state']);
            $shipper->setAdditionalAddressInformation1($addressData['addressAddition'][0] ?? null);
            $shipper->setAdditionalAddressInformation2($addressData['addressAddition'][1] ?? null);
            $shipper->setContactName($addressData['contactPerson']);
            $shipper->setPhone($addressData['phone']);
            $shipper->setEmail($addressData['email']);
            $shipper->setDispatchingInformation($addressData['dispatchingInformation']);
        } else {
            $shipper = new ShipperAddressRef($this->data['shipper']['reference']);
        }

        if (isset($this->data['recipient']['packstation'])) {
            $consignee = new Locker(
                $this->data['recipient']['address']['name'],
                (int) $this->data['recipient']['packstation']['number'],
                $this->data['recipient']['packstation']['postalCode'],
                $this->data['recipient']['packstation']['city'],
                $this->data['recipient']['packstation']['countryCode'],
                $this->data['recipient']['packstation']['postNumber']
            );
        } elseif (isset($this->data['recipient']['postfiliale'])) {
            if (
                empty($this->data['recipient']['address']['email'])
                && empty($this->data['recipient']['postfiliale']['postNumber'])
            ) {
                throw new RequestValidatorException(ShipmentOrderRequestBuilderInterface::MSG_MISSING_CONTACT);
            }

            $consignee = new PostOffice(
                $this->data['recipient']['address']['name'],
                (int) $this->data['recipient']['postfiliale']['number'],
                $this->data['recipient']['postfiliale']['postalCode'],
                $this->data['recipient']['postfiliale']['city'],
                $this->data['recipient']['postfiliale']['countryCode']
            );
            $consignee->setPostNumber($this->data['recipient']['postfiliale']['postNumber']);
            $consignee->setEmail($this->data['recipient']['address']['email'] ?? '');
        } elseif (isset($this->data['recipient']['pobox'])) {
            $consignee = new POBox(
                $this->data['recipient']['address']['name'],
                (int) $this->data['recipient']['pobox']['number'],
                $this->data['recipient']['pobox']['postalCode'],
                $this->data['recipient']['pobox']['city'],
                $this->data['recipient']['pobox']['countryCode']
            );
            $consignee->setEmail($this->data['recipient']['address']['email'] ?? '');
            $consignee->setName2($this->data['recipient']['address']['company'] ?? '');
            $consignee->setName3($this->data['recipient']['address']['nameAddition'] ?? '');
        } elseif (isset($this->data['recipient']['address'])) {
            $addressData = $this->data['recipient']['address'];
            $consignee = new ContactAddress(
                $addressData['name'],
                $addressData['streetName'],
                $addressData['postalCode'],
                $addressData['city'],
                $addressData['countryCode']
            );
            $consignee->setAddressHouse($addressData['streetNumber']);
            $consignee->setName2($addressData['company']);
            $consignee->setName3($addressData['nameAddition']);
            $consignee->setState($addressData['state']);
            $consignee->setAdditionalAddressInformation1($addressData['addressAddition'][0] ?? null);
            $consignee->setAdditionalAddressInformation2($addressData['addressAddition'][1] ?? null);
            $consignee->setContactName($addressData['contactPerson'] ?? null);
            $consignee->setPhone($addressData['phone'] ?? null);
            $consignee->setEmail($addressData['email'] ?? null);
            $consignee->setDispatchingInformation($addressData['dispatchingInformation']);
        } else {
            throw new RequestValidatorException(ShipmentOrderRequestBuilderInterface::MSG_MISSING_RECIPIENT);
        }

        $weight = new Weight('kg', $this->data['packageDetails']['weight']);
        $details = new Details($weight);
        if (isset($this->data['packageDetails']['dimensions'])) {
            $dim = new Dimension(
                'cm',
                $this->data['packageDetails']['dimensions']['height'],
                $this->data['packageDetails']['dimensions']['length'],
                $this->data['packageDetails']['dimensions']['width']
            );
            $details->setDim($dim);
        }

        $shipment = new Shipment(
            $this->data['shipmentDetails']['product'],
            $this->data['shipper']['billingNumber'],
            $this->data['shipmentDetails']['date'],
            $shipper,
            $consignee,
            $details
        );

        $shipment->setRefNo($this->data['shipmentDetails']['shipmentReference']);
        $shipment->setCostCenter($this->data['shipmentDetails']['costCentre']);
        $shipment->setCreationSoftware(''); // not supported yet

        if (
            isset($this->data['services'])
            || isset($this->data['return']['address'], $this->data['shipper']['returnBillingNumber'])
        ) {
            $services = new Services();
            $services->setPreferredNeighbour($this->data['services']['preferredNeighbour'] ?? null);
            $services->setPreferredLocation($this->data['services']['preferredLocation'] ?? null);
            $services->setPreferredDay($this->data['services']['preferredDay'] ?? null);
            $services->setVisualCheckOfAge($this->data['services']['visualCheckOfAge'] ?? null);
            $services->setNamedPersonOnly($this->data['services']['namedPersonOnly'] ?? null);
            $services->setNoNeighbourDelivery($this->data['services']['noNeighbourDelivery'] ?? null);
            $services->setIndividualSenderRequirement($this->data['services']['individualSenderRequirement'] ?? null);
            $services->setSignedForByRecipient($this->data['services']['signedForByRecipient'] ?? null);
            $services->setParcelOutletRouting($this->data['services']['parcelOutletRouting']['details'] ?? null);
            $services->setPremium($this->data['services']['premium'] ?? null);
            $services->setBulkyGoods($this->data['services']['bulkyGoods'] ?? null);
            $services->setPostalDeliveryDutyPaid($this->data['services']['pddp'] ?? null);

            match ($this->data['services']['endorsement'] ?? false) {
                ShipmentOrderRequestBuilderInterface::ENDORSEMENT_TYPE_IMMEDIATE => $services->setEndorsement('RETURN'),
                ShipmentOrderRequestBuilderInterface::ENDORSEMENT_TYPE_ABANDONMENT => $services->setEndorsement('ABANDON'),
                default => $services->setEndorsement(null),
            };

            switch ($this->data['services']['deliveryType'] ?? false) {
                case ShipmentOrderRequestBuilderInterface::DELIVERY_TYPE_ECONOMY:
                    $services->setPremium(false);
                    break;
                case ShipmentOrderRequestBuilderInterface::DELIVERY_TYPE_PREMIUM:
                    $services->setPremium(true);
                    break;
                case ShipmentOrderRequestBuilderInterface::DELIVERY_TYPE_CDP:
                    $services->setClosestDropPoint(true);
                    break;
            }

            if (isset($this->data['services']['cod']['codAmount'])) {
                $cod = new CashOnDelivery(new MonetaryValue('EUR', $this->data['services']['cod']['codAmount']));
                if (isset($this->data['shipper']['bankData'])) {
                    $bankAccount = new BankAccount(
                        $this->data['shipper']['bankData']['owner'] ?? '',
                        $this->data['shipper']['bankData']['iban'] ?? ''
                    );
                    $bankAccount->setBankName($this->data['shipper']['bankData']['bankName'] ?? null);
                    $bankAccount->setBic($this->data['shipper']['bankData']['bic']);
                    $cod->setBankAccount($bankAccount);
                    $cod->setAccountReference($this->data['shipper']['bankData']['accountReference'] ?? null);
                    $cod->setTransferNote1($this->data['shipper']['bankData']['notes'][0] ?? null);
                    $cod->setTransferNote2($this->data['shipper']['bankData']['notes'][1] ?? null);
                }

                $services->setCashOnDelivery($cod);
            }

            if (isset($this->data['services']['insuredValue'])) {
                $services->setAdditionalInsurance(new MonetaryValue('EUR', $this->data['services']['insuredValue']));
            }

            if (isset($this->data['services']['identCheck'])) {
                $ident = new IdentCheck(
                    $this->data['services']['identCheck']['surname'],
                    $this->data['services']['identCheck']['givenName']
                );
                $ident->setDateOfBirth($this->data['services']['identCheck']['dateOfBirth'] ?? null);
                $ident->setMinimumAge($this->data['services']['identCheck']['minimumAge'] ?? null);
                $services->setIdentCheck($ident);
            }

            if (isset($this->data['return']['address'])) {
                $addressData = $this->data['return']['address'];
                $returnAddress = new ReturnAddress(
                    $addressData['company'],
                    $addressData['streetName'],
                    $addressData['postalCode'],
                    $addressData['city'],
                    $addressData['countryCode']
                );
                $returnAddress->setName2($addressData['name']);
                $returnAddress->setName3($addressData['nameAddition']);
                $returnAddress->setState($addressData['state']);
                $returnAddress->setAddressHouse($addressData['streetNumber']);
                $returnAddress->setAdditionalAddressInformation1($addressData['addressAddition'][0] ?? null);
                $returnAddress->setAdditionalAddressInformation2($addressData['addressAddition'][1] ?? null);
                $returnAddress->setContactName($addressData['contactPerson']);
                $returnAddress->setPhone($addressData['phone']);
                $returnAddress->setEmail($addressData['email']);
                $returnAddress->setDispatchingInformation($addressData['dispatchingInformation']);

                $return = new DhlRetoure($this->data['shipper']['returnBillingNumber'], $returnAddress);
                $return->setRefNo($this->data['shipmentDetails']['returnReference'] ?? null);
                $services->setDhlRetoure($return);
            }

            $shipment->setServices($services);
        }

        if (isset($this->data['customsDetails'])) {
            $customsDetails = $this->data['customsDetails'];

            $exportItems = [];
            foreach ($customsDetails['items'] as $itemData) {
                $exportItem = new CustomsItem(
                    $itemData['description'],
                    $itemData['qty'],
                    new MonetaryValue('EUR', $itemData['value']),
                    new Weight('kg', $itemData['weight'])
                );
                $exportItem->setCountryOfOrigin($itemData['countryOfOrigin']);
                $exportItem->setHsCode($itemData['hsCode']);
                $exportItems[] = $exportItem;
            }

            $customs = new Customs($exportItems, $customsDetails['exportType']);
            $customs->setExportDescription($customsDetails['exportTypeDescription']);
            $customs->setPostalCharges(new MonetaryValue('EUR', $customsDetails['additionalFee']));
            $customs->setShippingConditions($customsDetails['termsOfTrade']);
            $customs->setInvoiceNo($customsDetails['invoiceNumber']);
            $customs->setPermitNo($customsDetails['permitNumber']);
            $customs->setAttestationNo($customsDetails['attestationNumber']);
            $customs->setOfficeOfOrigin($customsDetails['placeOfCommital']);
            $customs->setShipperCustomsRef($customsDetails['sendersCustomsReference']);
            $customs->setConsigneeCustomsRef($customsDetails['addresseesCustomsReference']);
            $customs->setHasElectronicExportNotification($customsDetails['electronicExportNotification'] ?? null);

            $shipment->setCustoms($customs);
        }

        $this->data = [];

        return $shipment;
    }
}
