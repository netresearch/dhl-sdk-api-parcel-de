<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Http;

use Dhl\Sdk\ParcelDe\Shipping\Api\Data\AuthenticationStorageInterface;
use Dhl\Sdk\ParcelDe\Shipping\Api\ServiceFactoryInterface;
use Dhl\Sdk\ParcelDe\Shipping\Api\ShipmentServiceInterface;
use Dhl\Sdk\ParcelDe\Shipping\Exception\ServiceExceptionFactory;
use Dhl\Sdk\ParcelDe\Shipping\Http\ClientPlugin\OrderErrorPlugin;
use Dhl\Sdk\ParcelDe\Shipping\Http\ClientPlugin\RequestValidatorPlugin;
use Dhl\Sdk\ParcelDe\Shipping\Model\ResponseMapper\CreateShipmentResponseMapper;
use Dhl\Sdk\ParcelDe\Shipping\Model\ResponseMapper\DeleteShipmentResponseMapper;
use Dhl\Sdk\ParcelDe\Shipping\Model\ResponseMapper\ValidateShipmentResponseMapper;
use Dhl\Sdk\ParcelDe\Shipping\Serializer\JsonSerializer;
use Dhl\Sdk\ParcelDe\Shipping\Service\ShipmentService;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\ContentLengthPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\Exception\NotFoundException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\Authentication\BasicAuth;
use Http\Message\Formatter\FullHttpMessageFormatter;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;

class HttpServiceFactory implements ServiceFactoryInterface
{
    /**
     * @var bool
     */
    private bool $schemaValidation = true;

    public function __construct(private readonly ClientInterface $httpClient, private readonly string $userAgent = '')
    {
    }

    public static function withSchemaValidationDisabled(ClientInterface $httpClient, string $userAgent = ''): self
    {
        $factory = new self($httpClient, $userAgent);
        $factory->schemaValidation = false;
        return $factory;
    }

    private function getUserAgent(): string
    {
        if (!empty($this->userAgent)) {
            return $this->userAgent;
        }

        if (!class_exists('\Composer\InstalledVersions')) {
            return 'dhl-sdk-api-bcs';
        }

        try {
            return 'dhl-sdk-api-bcs/' . \Composer\InstalledVersions::getVersion('dhl/sdk-api-bcs');
        } catch (\OutOfBoundsException $exception) {
            return 'dhl-sdk-api-bcs';
        }
    }

    public function createShipmentService(
        AuthenticationStorageInterface $authStorage,
        LoggerInterface $logger,
        bool $sandboxMode = false
    ): ShipmentServiceInterface {
        $userAuth = new BasicAuth($authStorage->getUser(), $authStorage->getPassword());

        $headers = [
            'Accept' => 'application/json, application/problem+json',
            'Content-Type' => 'application/json',
            'User-Agent' => $this->getUserAgent(),
            'dhl-api-key' => $authStorage->getApiKey(),
        ];

        $client = new PluginClient(
            $this->httpClient,
            [
                new HeaderDefaultsPlugin($headers),
                new AuthenticationPlugin($userAuth),
                new ContentLengthPlugin(),
                new RequestValidatorPlugin($logger, $this->schemaValidation),
                new LoggerPlugin($logger, new FullHttpMessageFormatter(null)),
                new OrderErrorPlugin($logger),
            ]
        );

        try {
            $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        } catch (NotFoundException $exception) {
            throw ServiceExceptionFactory::createServiceException($exception);
        }

        return new ShipmentService(
            $client,
            $sandboxMode ? self::BASE_URL_SANDBOX : self::BASE_URL_PRODUCTION,
            new JsonSerializer(),
            new ValidateShipmentResponseMapper(),
            new CreateShipmentResponseMapper(),
            new DeleteShipmentResponseMapper(),
            $requestFactory,
            $streamFactory
        );
    }
}
