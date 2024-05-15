<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\Expectation;

use Dhl\Sdk\ParcelDe\Shipping\Test\Expectation\Query\ArrayPath;
use Dhl\Sdk\ParcelDe\Shipping\Test\Expectation\Query\XPath;
use PHPUnit\Framework\Assert;

class RequestTypeExpectation
{
    private static function getDataByPath(string $path, array $data)
    {
        $keys = explode('/', $path);

        foreach ($keys as $key) {
            if ((array) $data === $data && isset($data[$key])) {
                $data = $data[$key];
            } else {
                return null;
            }
        }

        return $data;
    }

    public static function assertJsonContentsAvailable(array $requestData, string $requestBody): void
    {
        $requestData = array_values($requestData);
        $requestBody = json_decode($requestBody, true, 512, JSON_THROW_ON_ERROR);
        foreach ($requestData as $index => $shipmentOrderData) {
            $shipmentOrder = $requestBody['shipments'][$index];
            foreach ($shipmentOrderData as $key => $expectedValue) {
                $path = ArrayPath::get($key);
                if ($key === 'shipDate') {
                    $expectedValue = $expectedValue->format('Y-m-d');
                }
                Assert::assertEquals($expectedValue, self::getDataByPath($path, $shipmentOrder));
            }
        }
    }
}
