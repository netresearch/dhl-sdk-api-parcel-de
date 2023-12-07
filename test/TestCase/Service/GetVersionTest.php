<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\TestCase\Service;

use Dhl\Sdk\ParcelDe\Shipping\Api\Data\AuthenticationStorageInterface;
use Dhl\Sdk\ParcelDe\Shipping\Exception\ServiceException;
use Dhl\Sdk\ParcelDe\Shipping\Http\HttpServiceFactory;
use Dhl\Sdk\ParcelDe\Shipping\Test\Provider\Http\Service\GetVersionTestProvider;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;

class GetVersionTest extends TestCase
{
    /**
     * @return string[][]
     */
    public static function successDataProvider(): array
    {
        return GetVersionTestProvider::getVersionSuccess();
    }

    /**
     * Assert successful version call being processed properly.
     *
     * The only possible error cases are "401 Unauthorized" and "429 Too Many Requests",
     * which are not specific to the current endpoint and are therefore covered by another test.
     *
     *
     *
     * @throws ServiceException
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('successDataProvider')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function getApiVersionSuccess(AuthenticationStorageInterface $authStorage, string $responseBody): void
    {
        $httpClient = new Client();

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $getVersionResponse = $responseFactory
            ->createResponse(200, 'OK')
            ->withBody($streamFactory->createStream($responseBody));

        $httpClient->setDefaultResponse($getVersionResponse);
        $logger = new TestLogger();

        $serviceFactory = new HttpServiceFactory($httpClient);
        $service = $serviceFactory->createShipmentService($authStorage, $logger, true);
        $result = $service->getVersion();

        // assert that result is a version number
        self::assertMatchesRegularExpression('|\d\.\d\.\d|', $result);

        // assert that result is the version number from the response body
        $responseData = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);
        self::assertSame($result, $responseData['backend']['version']);
    }
}
