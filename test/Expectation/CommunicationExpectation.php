<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\Expectation;

use PHPUnit\Framework\Assert;
use Psr\Log\Test\TestLogger;

class CommunicationExpectation
{
    /**
     * Assert that messages are logged with info severity.
     */
    public static function assertCommunicationLogged(
        string $requestBody,
        string $responseBody,
        TestLogger $logger
    ): void {
        Assert::assertTrue($logger->hasInfoThatContains($requestBody), 'Info messages do not contain request.');
        Assert::assertTrue($logger->hasInfoThatContains($responseBody), 'Info messages do not contain response.');
    }

    /**
     * Assert that messages are logged with error severity.
     *
     * - REST client never logs warning severity.
     */
    public static function assertWarningsLogged(
        string $requestBody,
        string $responseBody,
        TestLogger $logger
    ): void {
        Assert::assertTrue($logger->hasWarningThatContains($requestBody), 'Warning messages do not contain request.');
        Assert::assertTrue($logger->hasWarningThatContains($responseBody), 'Warning messages do not contain response.');
    }

    /**
     * Assert that messages are logged with error severity.
     *
     * - REST client logs all requests with info severity.
     */
    public static function assertErrorsLogged(
        string $requestBody,
        string $responseBody,
        TestLogger $logger
    ): void {
        $isRequestLogged = $logger->hasErrorThatContains($requestBody) || $logger->hasInfoThatContains($requestBody);
        $isResponseLogged = $logger->hasErrorThatContains($responseBody);

        Assert::assertTrue($isRequestLogged, 'Logged messages do not contain request.');
        Assert::assertTrue($isResponseLogged, 'Logged messages do not contain response.');
    }
}
