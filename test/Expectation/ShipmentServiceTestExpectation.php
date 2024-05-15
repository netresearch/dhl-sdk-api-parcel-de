<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\Expectation;

use Dhl\Sdk\ParcelDe\Shipping\Api\Data\ShipmentInterface;
use Dhl\Sdk\ParcelDe\Shipping\Api\Data\ValidationResultInterface;
use PHPUnit\Framework\Assert;

class ShipmentServiceTestExpectation
{
    /**
     * @param ValidationResultInterface[] $result
     * @return ValidationResultInterface[][]
     */
    private static function sortValidationResult(array $result): array
    {
        return array_reduce(
            $result,
            function (array $carry, ValidationResultInterface $validationResult): array {
                if ($validationResult->isValid()) {
                    $carry['valid'][] = $validationResult->getRequestIndex();
                } else {
                    $carry['invalid'][] = $validationResult->getRequestIndex();
                }
                return $carry;
            },
            ['valid' => [], 'invalid' => []]
        );
    }

    /**
     * @param ValidationResultInterface[] $result
     */
    public static function assertValidationResponse(string $requestJson, string $responseJson, array $result): void
    {
        $request = \json_decode($requestJson, true, 512, JSON_THROW_ON_ERROR);
        $response = \json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);

        $actual = self::sortValidationResult($result);

        // assert that all sequence numbers of the request JSON are available in the SDK response
        $expected = array_keys($request['shipments']);
        Assert::assertEmpty(
            array_diff($expected, array_merge($actual['valid'], $actual['invalid'])),
            'Sequence numbers of the response do not match.'
        );

        // assert that all sequence numbers of the response JSON are available in the SDK response
        $expected = array_keys($response['items']);
        Assert::assertEmpty(
            array_diff($expected, array_merge($actual['valid'], $actual['invalid'])),
            'Sequence numbers of the response do not match.'
        );

        // assert that the response status was properly mapped to the response object.
        foreach ($response['items'] as $index => $item) {
            if ($item['sstatus']['statusCode'] === 200) {
                Assert::assertContains($index, $actual['valid']);
            } else {
                Assert::assertContains($index, $actual['invalid']);
            }
        }
    }

    public static function assertAllShipmentsCancelled(string $queryParams, string $responseJson, array $result): void
    {
        $response = \json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);

        preg_match_all('/shipment=([\d]+)/', $queryParams, $shipmentNumbers);
        $requested = $shipmentNumbers[1];

        $succeeded = array_map(
            fn(array $responseItem) => $responseItem['shipmentNo'],
            $response['items']
        );

        // assert all requested shipment numbers are contained in the response
        Assert::assertSame($requested, $succeeded, 'Shipment numbers of the response do not match.');
        // assert that all shipment numbers of the request are available in the SDK response
        Assert::assertSame($requested, $result, 'Shipment numbers of the response do not match.');
    }

    public static function assertSomeShipmentsCancelled(string $queryParams, string $responseJson, array $result): void
    {
        $response = \json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);

        preg_match_all('/shipment=([\d]+)/', $queryParams, $shipmentNumbers);
        $requested = $shipmentNumbers[1];

        $returned = array_reduce(
            $response['items'],
            function (array $carry, array $responseItem): array {
                if ($responseItem['sstatus']['statusCode'] === 200) {
                    $carry['succeeded'][] = $responseItem['shipmentNo'];
                } else {
                    $carry['failed'][] = $responseItem['shipmentNo'];
                }

                return $carry;
            },
            ['succeeded' => [], 'failed' => []]
        );

        // assert that all requested shipments are contained in the response
        Assert::assertEmpty(
            array_diff($requested, $returned['succeeded'], $returned['failed']),
            'Shipment numbers of the response do not match.'
        );

        // assert that all cancelled shipment numbers of the JSON response are available in the SDK response
        Assert::assertEmpty(
            array_diff($returned['succeeded'], $result),
            'Shipment numbers of the response do not match.'
        );

        // assert that shipments were cancelled but not all of them
        Assert::assertNotEmpty($result);
        Assert::assertLessThan(count($requested), count($result));
    }

    /**
     * @param string $requestJson Serialized request value to be asserted
     * @param string $responseJson Pre-recorded, expected value
     * @param ShipmentInterface[] $result Deserialized return value to be asserted
     */
    public static function assertShipmentsBooked(string $requestJson, string $responseJson, array $result): void
    {
        $request = \json_decode($requestJson, true, 512, JSON_THROW_ON_ERROR);
        $response = \json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);

        // assert that SDK request was serialized to expected number of JSON shipment objects
        Assert::assertCount(
            count($response['items']),
            $request['shipments'],
            'Request does not contain the expected number of shipments.'
        );

        // assert that SDK response contains all successfully created shipments
        $labels = array_reduce(
            $result,
            function (array $carry, ShipmentInterface $shipment): array {
                $carry[$shipment->getRequestIndex()] = $shipment->getLabels();
                return $carry;
            },
            []
        );

        foreach ($response['items'] as $index => $responseItem) {
            if ($responseItem['sstatus']['statusCode'] === 200) {
                // assert that successful API response items were mapped to SDK response items
                Assert::assertArrayHasKey($index, $labels);

                // assert that each SDK item contains all the label types included in the API item
                $responseLabels = array_filter(
                    [
                        $responseItem['label']['b64'] ?? '',
                        $responseItem['returnLabel']['b64'] ?? '',
                        $responseItem['codLabel']['b64'] ?? ''
                    ]
                );
                Assert::assertEmpty(
                    array_diff($responseLabels, $labels[$index]),
                    "Returned labels are not mapped to result for $index."
                );
            } else {
                // assert that failed response items were not mapped to SDK responses
                Assert::assertArrayNotHasKey($index, $labels);
            }
        }
    }
}
