<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\TestCase\Auth;

use Dhl\Sdk\ParcelDe\Shipping\Auth\AuthenticationStorage;
use PHPUnit\Framework\TestCase;

class AuthenticationStorageTest extends TestCase
{
    /**
     * @test
     */
    public function propertiesAreAvailableThroughGetters()
    {
        $apiKey = 'apiKey';
        $user = 'user';
        $password = 'password';

        $authStorage = new AuthenticationStorage($apiKey, $user, $password);

        self::assertSame($apiKey, $authStorage->getApiKey());
        self::assertSame($user, $authStorage->getUser());
        self::assertSame($password, $authStorage->getPassword());
    }
}
