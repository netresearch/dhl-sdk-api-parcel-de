<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Serializer;

use Dhl\Sdk\ParcelDe\Shipping\Model\ShipmentResponse;

/**
 * JsonSerializer
 *
 * Serializer for outgoing request types and incoming responses.
 */
class JsonSerializer
{
    /**
     * JsonSerializer constructor.
     *
     * @param string[] $classMap
     */
    public function __construct(private readonly array $classMap = [])
    {
    }

    /**
     * @throws \JsonException
     */
    public function encode(\JsonSerializable $request): string
    {
        // remove empty entries from serialized data (after all objects were converted to array)
        $payload = \json_encode($request, JSON_THROW_ON_ERROR);
        $payload = (array) \json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        $payload = $this->filterRecursive($payload);

        return \json_encode($payload, JSON_THROW_ON_ERROR);
    }

    /**
     * Recursively filter null and empty strings from the given (nested) array
     *
     * @param mixed[] $element
     * @return mixed[]
     */
    private function filterRecursive(array $element): array
    {
        // Filter null and empty strings
        $filterFunction = static fn($entry): bool => ($entry !== null) && ($entry !== '') && ($entry !== []);

        foreach ($element as &$value) {
            if (\is_array($value)) {
                $value = $this->filterRecursive($value);
            }
        }

        return array_filter($element, $filterFunction);
    }

    /**
     * @throws \JsonMapper_Exception
     * @throws \JsonException
     */
    public function decode(string $jsonResponse): ShipmentResponse
    {
        $jsonMapper = new \JsonMapper();
        $jsonMapper->bIgnoreVisibility = true;
        $jsonMapper->classMap = $this->classMap;

        $response = \json_decode($jsonResponse, false, 512, JSON_THROW_ON_ERROR);

        /** @var ShipmentResponse $mappedResponse */
        $mappedResponse = $jsonMapper->map($response, new ShipmentResponse());

        return $mappedResponse;
    }
}
