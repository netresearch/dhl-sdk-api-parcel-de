<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\Expectation\Query;

class ArrayPath
{
    final public const PATH_MUST_ENCODE = './ShipmentOrder/PrintOnlyIfCodeable/@active';
    final public const PATH_LABEL_RESPONSE_TYPE = './labelResponseType';
    final public const PATH_GROUP_PROFILE_NAME = './groupProfileName';
    final public const PATH_LABEL_FORMAT = './labelFormat';
    final public const PATH_LABEL_FORMAT_RETOURE = './labelFormatRetoure';
    final public const PATH_COMBINED_PRINTING = './combinedPrinting';

    // formerly SequenceNumber
    final public const PATH_REQUEST_INDEX = ''; // N/A
    final public const PATH_ACCOUNT_NUMBER = 'billingNumber';
    final public const PATH_RETURN_ACCOUNT_NUMBER = 'services/dhlRetoure/billingNumber';

    final public const PATH_PRODUCT = 'product';
    final public const PATH_SHIPMENT_DATE = 'shipDate';

    final public const PATH_CUSTOMER_REFERENCE = 'refNo';
    final public const PATH_RETURN_REFERENCE = 'services/dhlRetoure/refNo';
    final public const PATH_COST_CENTRE = 'costCenter';

    final public const PATH_SHIPPER_COMPANY = 'shipper/name1';
    final public const PATH_SHIPPER_NAME = 'shipper/name2';
    final public const PATH_SHIPPER_NAME_ADDITION = 'shipper/name3';
    final public const PATH_SHIPPER_EMAIL = 'shipper/email';
    final public const PATH_SHIPPER_PHONE = 'shipper/phone';
    final public const PATH_SHIPPER_CONTACT_PERSON = 'shipper/contactName';
    final public const PATH_SHIPPER_COUNTRY = 'shipper/country';
    final public const PATH_SHIPPER_STATE = 'shipper/state';
    final public const PATH_SHIPPER_POSTAL_CODE = 'shipper/postalCode';
    final public const PATH_SHIPPER_CITY = 'shipper/city';
    final public const PATH_SHIPPER_STREET_NAME = 'shipper/addressStreet';
    final public const PATH_SHIPPER_STREET_NUMBER = 'shipper/addressHouse';
    final public const PATH_SHIPPER_ADDRESS_ADD1 = 'shipper/additionalAddressInformation1';
    final public const PATH_SHIPPER_ADDRESS_ADD2 = 'shipper/additionalAddressInformation2';
    final public const PATH_SHIPPER_DISPATCH_INFO = 'shipper/dispatchingInformation';
    final public const PATH_SHIPPER_REFERENCE = 'shipper/shipperRef';

    final public const PATH_SHIPPER_BANK_OWNER = 'services/cashOnDelivery/bankAccount/accountHolder';
    final public const PATH_SHIPPER_BANK_NAME = 'services/cashOnDelivery/bankAccount/bankName';
    final public const PATH_SHIPPER_BANK_IBAN = 'services/cashOnDelivery/bankAccount/iban';
    final public const PATH_SHIPPER_BANK_BIC = 'services/cashOnDelivery/bankAccount/bic';
    final public const PATH_SHIPPER_BANK_REFERENCE = 'services/cashOnDelivery/accountReference';
    final public const PATH_SHIPPER_BANK_NOTE1 = 'services/cashOnDelivery/transferNote1';
    final public const PATH_SHIPPER_BANK_NOTE2 = 'services/cashOnDelivery/transferNote2';

    final public const PATH_RETURN_COMPANY = 'services/dhlRetoure/returnAddress/name1';
    final public const PATH_RETURN_NAME = 'services/dhlRetoure/returnAddress/name2';
    final public const PATH_RETURN_NAME_ADDITION = 'services/dhlRetoure/returnAddress/name3';
    final public const PATH_RETURN_EMAIL = 'services/dhlRetoure/returnAddress/email';
    final public const PATH_RETURN_PHONE = 'services/dhlRetoure/returnAddress/phone';
    final public const PATH_RETURN_CONTACT_PERSON = 'services/dhlRetoure/returnAddress/contactName';
    final public const PATH_RETURN_COUNTRY = 'services/dhlRetoure/returnAddress/country';
    final public const PATH_RETURN_STATE = 'services/dhlRetoure/returnAddress/state';
    final public const PATH_RETURN_POSTAL_CODE = 'services/dhlRetoure/returnAddress/postalCode';
    final public const PATH_RETURN_CITY = 'services/dhlRetoure/returnAddress/city';
    final public const PATH_RETURN_STREET_NAME = 'services/dhlRetoure/returnAddress/addressStreet';
    final public const PATH_RETURN_STREET_NUMBER = 'services/dhlRetoure/returnAddress/addressHouse';
    final public const PATH_RETURN_ADDRESS_ADD1 = 'services/dhlRetoure/returnAddress/additionalAddressInformation1';
    final public const PATH_RETURN_ADDRESS_ADD2 = 'services/dhlRetoure/returnAddress/additionalAddressInformation2';
    final public const PATH_RETURN_DISPATCH_INFO = 'services/dhlRetoure/returnAddress/dispatchingInformation';

    final public const PATH_RECIPIENT_NAME = 'consignee/name1';
    final public const PATH_RECIPIENT_COMPANY = 'consignee/name2';
    final public const PATH_RECIPIENT_NAME_ADDITION = 'consignee/name3';
    final public const PATH_RECIPIENT_EMAIL = 'consignee/email';
    final public const PATH_RECIPIENT_PHONE = 'consignee/phone';
    final public const PATH_RECIPIENT_CONTACT_PERSON = 'consignee/contactName';
    final public const PATH_RECIPIENT_COUNTRY = 'consignee/country';
    final public const PATH_RECIPIENT_STATE = 'consignee/state';
    final public const PATH_RECIPIENT_POSTAL_CODE = 'consignee/postalCode';
    final public const PATH_RECIPIENT_CITY = 'consignee/city';
    final public const PATH_RECIPIENT_STREET_NAME = 'consignee/addressStreet';
    final public const PATH_RECIPIENT_STREET_NUMBER = 'consignee/addressHouse';
    final public const PATH_RECIPIENT_ADDRESS_ADD1 = 'consignee/additionalAddressInformation1';
    final public const PATH_RECIPIENT_ADDRESS_ADD2 = 'consignee/additionalAddressInformation2';
    final public const PATH_RECIPIENT_DISPATCH_INFO = 'consignee/dispatchingInformation';

    final public const PATH_PACKSTATION_NAME = 'consignee/name';
    final public const PATH_PACKSTATION_NUMBER = 'consignee/lockerID';
    final public const PATH_PACKSTATION_POSTAL_CODE = 'consignee/postalCode';
    final public const PATH_PACKSTATION_CITY = 'consignee/city';
    final public const PATH_PACKSTATION_POST_NUMBER = 'consignee/postNumber';
    final public const PATH_PACKSTATION_PROVINCE = ''; // N/A
    final public const PATH_PACKSTATION_COUNTRY_CODE = 'consignee/country';
    final public const PATH_PACKSTATION_COUNTRY = ''; // N/A
    final public const PATH_PACKSTATION_STATE = ''; // N/A

    final public const PATH_POSTFILIALE_NAME = 'consignee/name';
    final public const PATH_POSTFILIALE_NUMBER = 'consignee/retailID';
    final public const PATH_POSTFILIALE_POST_NUMBER = 'consignee/postNumber';
    final public const PATH_POSTFILIALE_POSTAL_CODE = 'consignee/postalCode';
    final public const PATH_POSTFILIALE_CITY = 'consignee/city';
    final public const PATH_POSTFILIALE_EMAIL = 'consignee/email';
    final public const PATH_POSTFILIALE_COUNTRY = ''; // N/A
    final public const PATH_POSTFILIALE_COUNTRY_CODE = 'consignee/country';
    final public const PATH_POSTFILIALE_STATE = ''; // N/A

    final public const PATH_POBOX_NAME = 'consignee/name1';
    final public const PATH_POBOX_NUMBER = 'consignee/poBoxID';
    final public const PATH_POBOX_POSTAL_CODE = 'consignee/postalCode';
    final public const PATH_POBOX_CITY = 'consignee/city';
    final public const PATH_POBOX_COUNTRY = ''; // N/A
    final public const PATH_POBOX_COUNTRY_CODE = 'consignee/country';

    final public const PATH_WEIGHT = 'details/weight/value';
    final public const PATH_INSURED_VALUE = 'services/additionalInsurance/value';
    final public const PATH_COD_AMOUNT = 'services/cashOnDelivery/amount/value';
    final public const PATH_COD_ADD_FEE = ''; // N/A

    final public const PATH_PACKAGE_LENGTH = 'details/dim/length';
    final public const PATH_PACKAGE_WIDTH = 'details/dim/width';
    final public const PATH_PACKAGE_HEIGHT = 'details/dim/height';

    final public const PATH_EXPORT_TYPE = 'customs/exportType';
    final public const PATH_EXPORT_PLACE = 'customs/officeOfOrigin';
    final public const PATH_EXPORT_FEE = 'customs/postalCharges/value';
    final public const PATH_EXPORT_DESCRIPTION = 'customs/exportDescription';
    final public const PATH_EXPORT_INCOTERMS = 'customs/shippingConditions';
    final public const PATH_EXPORT_INVOICE_NO = 'customs/invoiceNo';
    final public const PATH_EXPORT_PERMIT_NO = 'customs/permitNo';
    final public const PATH_EXPORT_ATTESTATION_NO = 'customs/attestationNo';
    final public const PATH_EXPORT_NOTIFICATION = 'customs/hasElectronicExportNotification';
    final public const PATH_EXPORT_ITEM1_QTY = 'customs/items/0/packagedQuantity';
    final public const PATH_EXPORT_ITEM1_DESC = 'customs/items/0/itemDescription';
    final public const PATH_EXPORT_ITEM1_WEIGHT = 'customs/items/0/itemWeight/value';
    final public const PATH_EXPORT_ITEM1_VALUE = 'customs/items/0/itemValue/value';
    final public const PATH_EXPORT_ITEM1_HSCODE = 'customs/items/0/hsCode';
    final public const PATH_EXPORT_ITEM1_ORIGIN = 'customs/items/0/countryOfOrigin';
    final public const PATH_EXPORT_ITEM2_QTY = 'customs/items/1/packagedQuantity';
    final public const PATH_EXPORT_ITEM2_DESC = 'customs/items/1/itemDescription';
    final public const PATH_EXPORT_ITEM2_WEIGHT = 'customs/items/1/itemWeight/value';
    final public const PATH_EXPORT_ITEM2_VALUE = 'customs/items/1/itemValue/value';
    final public const PATH_EXPORT_ITEM2_HSCODE = 'customs/items/1/hsCode';
    final public const PATH_EXPORT_ITEM2_ORIGIN = 'customs/items/1/countryOfOrigin';

    final public const PATH_SERVICE_PREFERRED_DAY = 'services/preferredDay';
    final public const PATH_SERVICE_PREFERRED_TIME = ''; // N/A
    final public const PATH_SERVICE_PREFERRED_LOCATION = 'services/preferredLocation';
    final public const PATH_SERVICE_PREFERRED_NEIGHBOUR = 'services/preferredNeighbour';
    final public const PATH_SERVICE_SENDER_REQUIREMENT = 'services/individualSenderRequirement';
    final public const PATH_SERVICE_AGECHECK = 'services/visualCheckOfAge';
    final public const PATH_SERVICE_GOGREEN = ''; // N/A
    final public const PATH_SERVICE_PERISHABLES = ''; // N/A
    final public const PATH_SERVICE_PERSONALLY = ''; // N/A
    final public const PATH_SERVICE_NO_NEIGHBOUR_DELIVERY = 'services/noNeighbourDelivery';
    final public const PATH_SERVICE_NAMES_PERSON_ONLY = 'services/namedPersonOnly';
    final public const PATH_SERVICE_RETURN_RECEIPT = ''; // N/A
    final public const PATH_SERVICE_PDDP = 'services/postalDeliveryDutyPaid';
    final public const PATH_SERVICE_PREMIUM = 'services/premium';
    final public const PATH_SERVICE_CDP = 'services/closestDropPoint';
    final public const PATH_SERVICE_BULKY_GOODS = 'services/bulkyGoods';
    final public const PATH_SERVICE_SIGNED_BY_RECIPIENT = 'services/signedForByRecipient';
    final public const PATH_SERVICE_IDENT_LASTNAME = 'services/identCheck/lastName';
    final public const PATH_SERVICE_IDENT_FIRSTNAME = 'services/identCheck/firstName';
    final public const PATH_SERVICE_IDENT_DOB = 'services/identCheck/dateOfBirth';
    final public const PATH_SERVICE_IDENT_MINAGE = 'services/identCheck/minimumAge';
    final public const PATH_SERVICE_ROUTING = 'services/parcelOutletRouting';
    final public const PATH_SERVICE_GOGREEN_PLUS = 'services/goGreenPlus';
    final public const PATH_SERVICE_RETURN_GOGREEN_PLUS = 'services/returnShipmentGoGreenPlus';

    public static function get(string $attribute): string
    {
        $map = [
            'mustEncode' => self::PATH_MUST_ENCODE,
            'labelResponseType' => self::PATH_LABEL_RESPONSE_TYPE,
            'groupProfileName' => self::PATH_GROUP_PROFILE_NAME,
            'labelFormat' => self::PATH_LABEL_FORMAT,
            'labelFormatRetoure' => self::PATH_LABEL_FORMAT_RETOURE,
            'combinedPrinting' => self::PATH_COMBINED_PRINTING,

            'requestIndex' => self::PATH_REQUEST_INDEX,
            'billingNumber' => self::PATH_ACCOUNT_NUMBER,
            'returnBillingNumber' => self::PATH_RETURN_ACCOUNT_NUMBER,
            'productCode' => self::PATH_PRODUCT,
            'shipDate' => self::PATH_SHIPMENT_DATE,
            'customerReference' => self::PATH_CUSTOMER_REFERENCE,
            'returnReference' => self::PATH_RETURN_REFERENCE,
            'costCentre' => self::PATH_COST_CENTRE,

            'shipperName' => self::PATH_SHIPPER_NAME,
            'shipperNameAddition' => self::PATH_SHIPPER_NAME_ADDITION,
            'shipperCompany' => self::PATH_SHIPPER_COMPANY,
            'shipperEmail' => self::PATH_SHIPPER_EMAIL,
            'shipperPhone' => self::PATH_SHIPPER_PHONE,
            'shipperContactPerson' => self::PATH_SHIPPER_CONTACT_PERSON,
            'shipperCountryCode' => self::PATH_SHIPPER_COUNTRY,
            'shipperState' => self::PATH_SHIPPER_STATE,
            'shipperPostalCode' => self::PATH_SHIPPER_POSTAL_CODE,
            'shipperCity' => self::PATH_SHIPPER_CITY,
            'shipperStreet' => self::PATH_SHIPPER_STREET_NAME,
            'shipperStreetNumber' => self::PATH_SHIPPER_STREET_NUMBER,
            'shipperAddressAddition1' => self::PATH_SHIPPER_ADDRESS_ADD1,
            'shipperAddressAddition2' => self::PATH_SHIPPER_ADDRESS_ADD2,
            'shipperDispatchingInformation' => self::PATH_SHIPPER_DISPATCH_INFO,
            'shipperReference' => self::PATH_SHIPPER_REFERENCE,

            'shipperBankOwner' => self::PATH_SHIPPER_BANK_OWNER,
            'shipperBankName' => self::PATH_SHIPPER_BANK_NAME,
            'shipperBankIban' => self::PATH_SHIPPER_BANK_IBAN,
            'shipperBankBic' => self::PATH_SHIPPER_BANK_BIC,
            'shipperBankReference' => self::PATH_SHIPPER_BANK_REFERENCE,
            'shipperBankNote1' => self::PATH_SHIPPER_BANK_NOTE1,
            'shipperBankNote2' => self::PATH_SHIPPER_BANK_NOTE2,

            'returnName' => self::PATH_RETURN_NAME,
            'returnNameAddition' => self::PATH_RETURN_NAME_ADDITION,
            'returnCompany' => self::PATH_RETURN_COMPANY,
            'returnEmail' => self::PATH_RETURN_EMAIL,
            'returnPhone' => self::PATH_RETURN_PHONE,
            'returnContactPerson' => self::PATH_RETURN_CONTACT_PERSON,
            'returnCountryCode' => self::PATH_RETURN_COUNTRY,
            'returnState' => self::PATH_RETURN_STATE,
            'returnPostalCode' => self::PATH_RETURN_POSTAL_CODE,
            'returnCity' => self::PATH_RETURN_CITY,
            'returnStreet' => self::PATH_RETURN_STREET_NAME,
            'returnStreetNumber' => self::PATH_RETURN_STREET_NUMBER,
            'returnAddressAddition1' => self::PATH_RETURN_ADDRESS_ADD1,
            'returnAddressAddition2' => self::PATH_RETURN_ADDRESS_ADD2,
            'returnDispatchingInformation' => self::PATH_RETURN_DISPATCH_INFO,

            'recipientName' => self::PATH_RECIPIENT_NAME,
            'recipientNameAddition' => self::PATH_RECIPIENT_NAME_ADDITION,
            'recipientCompany' => self::PATH_RECIPIENT_COMPANY,
            'recipientEmail' => self::PATH_RECIPIENT_EMAIL,
            'recipientPhone' => self::PATH_RECIPIENT_PHONE,
            'recipientContactPerson' => self::PATH_RECIPIENT_CONTACT_PERSON,
            'recipientCountryCode' => self::PATH_RECIPIENT_COUNTRY,
            'recipientState' => self::PATH_RECIPIENT_STATE,
            'recipientPostalCode' => self::PATH_RECIPIENT_POSTAL_CODE,
            'recipientCity' => self::PATH_RECIPIENT_CITY,
            'recipientStreet' => self::PATH_RECIPIENT_STREET_NAME,
            'recipientStreetNumber' => self::PATH_RECIPIENT_STREET_NUMBER,
            'recipientAddressAddition1' => self::PATH_RECIPIENT_ADDRESS_ADD1,
            'recipientAddressAddition2' => self::PATH_RECIPIENT_ADDRESS_ADD2,
            'recipientDispatchingInformation' => self::PATH_RECIPIENT_DISPATCH_INFO,

            'packstationRecipientName' => self::PATH_PACKSTATION_NAME,
            'packstationNumber' => self::PATH_PACKSTATION_NUMBER,
            'packstationPostalCode' => self::PATH_PACKSTATION_POSTAL_CODE,
            'packstationCity' => self::PATH_PACKSTATION_CITY,
            'packstationPostNumber' => self::PATH_PACKSTATION_POST_NUMBER,
            'packstationState' => self::PATH_PACKSTATION_STATE,
            'packstationProvince' => self::PATH_PACKSTATION_PROVINCE,
            'packstationCountry' => self::PATH_PACKSTATION_COUNTRY,
            'packstationCountryCode' => self::PATH_PACKSTATION_COUNTRY_CODE,

            'postfilialRecipientName' => self::PATH_POSTFILIALE_NAME,
            'postfilialNumber' => self::PATH_POSTFILIALE_NUMBER,
            'postfilialPostNumber' => self::PATH_POSTFILIALE_POST_NUMBER,
            'postfilialPostalCode' => self::PATH_POSTFILIALE_POSTAL_CODE,
            'postfilialCity' => self::PATH_POSTFILIALE_CITY,
            'postfilialEmail' => self::PATH_POSTFILIALE_EMAIL,
            'postfilialCountry' => self::PATH_POSTFILIALE_COUNTRY,
            'postfilialCountryCode' => self::PATH_POSTFILIALE_COUNTRY_CODE,
            'postfilialState' => self::PATH_POSTFILIALE_STATE,

            'poBoxRecipientName' => self::PATH_POBOX_NAME,
            'poBoxNumber' => self::PATH_POBOX_NUMBER,
            'poBoxPostalCode' => self::PATH_POBOX_POSTAL_CODE,
            'poBoxCity' => self::PATH_POBOX_CITY,
            'poBoxCountry' => self::PATH_POBOX_COUNTRY,
            'poBoxCountryCode' => self::PATH_POBOX_COUNTRY_CODE,

            'packageWeight' => self::PATH_WEIGHT,
            'packageValue' => self::PATH_INSURED_VALUE,
            'packageLength' => self::PATH_PACKAGE_LENGTH,
            'packageWidth' => self::PATH_PACKAGE_WIDTH,
            'packageHeight' => self::PATH_PACKAGE_HEIGHT,

            'exportType' => self::PATH_EXPORT_TYPE,
            'placeOfCommital' => self::PATH_EXPORT_PLACE,
            'additionalFee' => self::PATH_EXPORT_FEE,
            'exportTypeDescription' => self::PATH_EXPORT_DESCRIPTION,
            'termsOfTrade' => self::PATH_EXPORT_INCOTERMS,
            'invoiceNumber' => self::PATH_EXPORT_INVOICE_NO,
            'permitNumber' => self::PATH_EXPORT_PERMIT_NO,
            'attestationNumber' => self::PATH_EXPORT_ATTESTATION_NO,
            'electronicExportNotification' => self::PATH_EXPORT_NOTIFICATION,
            'exportItem1Qty' => self::PATH_EXPORT_ITEM1_QTY,
            'exportItem1Desc' => self::PATH_EXPORT_ITEM1_DESC,
            'exportItem1Weight' => self::PATH_EXPORT_ITEM1_WEIGHT,
            'exportItem1Value' => self::PATH_EXPORT_ITEM1_VALUE,
            'exportItem1HsCode' => self::PATH_EXPORT_ITEM1_HSCODE,
            'exportItem1Origin' => self::PATH_EXPORT_ITEM1_ORIGIN,
            'exportItem2Qty' => self::PATH_EXPORT_ITEM2_QTY,
            'exportItem2Desc' => self::PATH_EXPORT_ITEM2_DESC,
            'exportItem2Weight' => self::PATH_EXPORT_ITEM2_WEIGHT,
            'exportItem2Value' => self::PATH_EXPORT_ITEM2_VALUE,
            'exportItem2HsCode' => self::PATH_EXPORT_ITEM2_HSCODE,
            'exportItem2Origin' => self::PATH_EXPORT_ITEM2_ORIGIN,

            'codAmount' => self::PATH_COD_AMOUNT,
            'addCodFee' => self::PATH_COD_ADD_FEE,

            'preferredDay' => self::PATH_SERVICE_PREFERRED_DAY,
            'preferredTime' => self::PATH_SERVICE_PREFERRED_TIME,
            'preferredLocation' => self::PATH_SERVICE_PREFERRED_LOCATION,
            'preferredNeighbour' => self::PATH_SERVICE_PREFERRED_NEIGHBOUR,
            'senderRequirement' => self::PATH_SERVICE_SENDER_REQUIREMENT,
            'visualCheckOfAge' => self::PATH_SERVICE_AGECHECK,
            'goGreen' => self::PATH_SERVICE_GOGREEN,
            'perishables' => self::PATH_SERVICE_PERISHABLES,
            'personally' => self::PATH_SERVICE_PERSONALLY,
            'noNeighbourDelivery' => self::PATH_SERVICE_NO_NEIGHBOUR_DELIVERY,
            'namedPersonOnly' => self::PATH_SERVICE_NAMES_PERSON_ONLY,
            'returnReceipt' => self::PATH_SERVICE_RETURN_RECEIPT,
            'postalDeliveryDutyPaid' => self::PATH_SERVICE_PDDP,
            'premium' => self::PATH_SERVICE_PREMIUM,
            'closestDropPoint' => self::PATH_SERVICE_CDP,
            'bulkyGoods' => self::PATH_SERVICE_BULKY_GOODS,
            'signedForByRecipient' => self::PATH_SERVICE_SIGNED_BY_RECIPIENT,
            'identLastName' => self::PATH_SERVICE_IDENT_LASTNAME,
            'identFirstName' => self::PATH_SERVICE_IDENT_FIRSTNAME,
            'identDob' => self::PATH_SERVICE_IDENT_DOB,
            'identMinAge' => self::PATH_SERVICE_IDENT_MINAGE,
            'parcelOutletRouting' => self::PATH_SERVICE_ROUTING,
            'goGreenPlus' => self::PATH_SERVICE_GOGREEN_PLUS,
            'returnShipmentGoGreenPlus' => self::PATH_SERVICE_RETURN_GOGREEN_PLUS,
        ];

        return $map[$attribute];
    }
}
