# DHL Parcel DE Shipping API SDK

The DHL Parcel DE Shipping API SDK package offers an interface to the following web services:

- [DHL Parcel DE Shipping 2.1.7](https://developer.dhl.com/api-reference/parcel-de-shipping-post-parcel-germany-v2)

## Requirements

### System Requirements

- PHP 8.1+ with SOAP and JSON extension

### Package Requirements

- `league/openapi-psr7-validator`: Schema validator for JSON request messages
- `netresearch/jsonmapper`: Mapper for deserialization of JSON response messages into PHP objects
- `php-http/discovery`: Discovery service for HTTP client and message factory implementations
- `php-http/httplug`: Pluggable HTTP client abstraction
- `php-http/logger-plugin`: HTTP client logger plugin for HTTPlug
- `psr/http-client`: PSR-18 HTTP client interfaces
- `psr/http-factory`: PSR-7 HTTP message factory interfaces
- `psr/http-message`: PSR-7 HTTP message interfaces
- `psr/log`: PSR-3 logger interfaces

### Virtual Package Requirements

- `psr/http-client-implementation`: Any package that provides a PSR-18 compatible HTTP client
- `psr/http-factory-implementation`: Any package that provides PSR-7 compatible HTTP message factories
- `psr/http-message-implementation`: Any package that provides PSR-7 HTTP messages

### Development Package Requirements

- `fig/log-test`: PSR-3 logger implementation for testing purposes
- `nyholm/psr7`: PSR-7 HTTP message factory & message implementation
- `phpunit/phpunit`: Testing framework
- `php-http/mock-client`: HTTPlug mock client implementation
- `phpstan/phpstan`: Static analysis tool
- `rector/rector`: Automatic refactoring tool to help with PHP upgrades
- `squizlabs/php_codesniffer`: Static analysis tool

## Installation

```bash
$ composer require dhl/sdk-api-parcel-de
```

## Uninstallation

```bash
$ composer remove dhl/sdk-api-parcel-de
```

## Testing

```bash
$ ./vendor/bin/phpunit -c test/phpunit.xml
```

## Features

The DHL Parcel DE Shipping API SDK supports the following features:

* Validate Shipment
* Create Shipment Order
* Delete Shipment Order

### Authentication

The DHL Parcel DE Shipping API requires a two-level authentication
(see [API User Guide](https://developer.dhl.com/api-reference/parcel-de-shipping-post-parcel-germany-v2#get-started-section/user-guide)):

1. The **application** submits a _Consumer Key Header_ ("API Key") that must be
   created in the [DHL API Developer Portal](https://developer.dhl.com/user/apps).
2. The **user** is identified via _HTTP Basic Authentication_ with credentials
   configured in the [DHL Business Customer Portal](https://geschaeftskunden.dhl.de/).

These credentials are passed to the SDK via `\Dhl\Sdk\ParcelDe\Shipping\Api\Data\AuthenticationStorageInterface`.
Create your own or use the default implementation:

```php
$authStorage = new \Dhl\Sdk\ParcelDe\Shipping\Auth\AuthenticationStorage('apiKey', 'user', 'password');
```

### Validate Shipment

Validate shipments for DHL Paket including the relevant shipping documents.

#### Public API

The library's components suitable for consumption comprise

* services:
  * service factory
  * shipment service
  * data transfer object builder
* data transfer objects:
  * [authentication storage](#Authentication)
  * order/label settings
  * validation result with status message

#### Usage

```php
$logger = new \Psr\Log\NullLogger();

$serviceFactory = new \Dhl\Sdk\ParcelDe\Shipping\Service\ServiceFactory();
$service = $serviceFactory->createShipmentService($authStorage, $logger, $sandbox = true);

$requestBuilder = new \Dhl\Sdk\ParcelDe\Shipping\RequestBuilder\ShipmentOrderRequestBuilder();
$requestBuilder->setShipperAccount($billingNumber = '33333333330101');
$requestBuilder->setShipperAddress(
    company: 'DHL',
    country: 'DEU',
    postalCode: '53113',
    city: 'Bonn',
    street: 'Charles-de-Gaulle-Straße',
    streetNumber: '20'
);
$requestBuilder->setRecipientAddress(
    recipientName: 'Jane Doe',
    recipientCountry: 'DEU',
    recipientPostalCode: '53113',
    recipientCity: 'Bonn',
    recipientStreet: 'Sträßchensweg',
    recipientStreetNumber: '2'
);
$requestBuilder->setShipmentDetails(productCode: 'V01PAK', shipmentDate: new \DateTimeImmutable('2023-02-23'));
$requestBuilder->setPackageDetails(weightInKg: 2.4);

$shipmentOrder = $requestBuilder->create();
$result = $service->validateShipments([$shipmentOrder]);
```
### Create Shipment Order

Create shipments for DHL Paket including the relevant shipping documents. In
addition to the primary shipment data (shipper, consignee, etc.), further
settings can be defined per request via the _order configuration_ object, including
label printing size, profile, and more.

#### Public API

The library's components suitable for consumption comprise

* services:
  * service factory
  * shipment service
  * data transfer object builder
* data transfer objects:
  * [authentication storage](#Authentication)
  * order/label settings
  * shipment with shipment/tracking number and label(s)

#### Usage

```php
$logger = new \Psr\Log\NullLogger();

$serviceFactory = new \Dhl\Sdk\ParcelDe\Shipping\Service\ServiceFactory();
$service = $serviceFactory->createShipmentService($authStorage, $logger, sandbox: true);

$orderConfiguration = new \Dhl\Sdk\ParcelDe\Shipping\Service\ShipmentService\OrderConfiguration(
    mustEncode: true,
    combinedPrinting: null,
    docFormat: \Dhl\Sdk\ParcelDe\Shipping\Api\Data\OrderConfigurationInterface::DOC_FORMAT_PDF,
    printFormat: \Dhl\Sdk\ParcelDe\Shipping\Api\Data\OrderConfigurationInterface::PRINT_FORMAT_A4
);

$requestBuilder = new \Dhl\Sdk\ParcelDe\Shipping\RequestBuilder\ShipmentOrderRequestBuilder();
$requestBuilder->setShipperAccount(billingNumber: '33333333330101');
$requestBuilder->setShipperAddress(
    company: 'DHL',
    country: 'DEU',
    postalCode: '53113',
    city: 'Bonn',
    streetName: 'Charles-de-Gaulle-Straße',
    streetNumber: '20'
);
$requestBuilder->setRecipientAddress(
    name: 'Jane Doe',
    countryCode: 'DEU',
    postalCode: '53113',
    city: 'Bonn',
    streetName: 'Sträßchensweg',
    streetNumber: '2'
);
$requestBuilder->setShipmentDetails(productCode: 'V01PAK', shipmentDate: new \DateTimeImmutable('2023-02-23'));
$requestBuilder->setPackageDetails(weightInKg: 2.4);

$shipmentOrder = $requestBuilder->create();
$shipments = $service->createShipments([$shipmentOrder], $orderConfiguration);
```

### Delete Shipment Order

Cancel earlier created shipments.

#### Public API

The library's components suitable for consumption comprise

* services:
  * service factory
  * shipment service
* data transfer objects:
  * authentication storage

#### Usage

```php
$logger = new \Psr\Log\NullLogger();

$serviceFactory = new \Dhl\Sdk\ParcelDe\Shipping\Service\ServiceFactory();
$service = $serviceFactory->createShipmentService($authStorage, $logger, sandbox: true);

$shipmentNumber = '333301011234567890';
$cancelled = $service->cancelShipments([$shipmentNumber]);
```
