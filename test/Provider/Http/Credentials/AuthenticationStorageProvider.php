<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Test\Provider\Http\Credentials;

use Dhl\Sdk\ParcelDe\Shipping\Auth\AuthenticationStorage;

class AuthenticationStorageProvider
{
    /**
     * Provide authentication with invalid app token.
     */
    public static function appAuthFailure(): AuthenticationStorage
    {
        return new AuthenticationStorage(
            'eeeeehh…',
            '3333333333_01',
            'pass'
        );
    }

    /**
     * Provide authentication with invalid user signature.
     */
    public static function userAuthFailure(): AuthenticationStorage
    {
        return new AuthenticationStorage(
            '7eelE1paJtbWvAKw0ROgVNLZak6rvEoD',
            '3333333333_01',
            'no-pass'
        );
    }

    /**
     * Provide authentication with valid credentials.
     */
    public static function authSuccess(): AuthenticationStorage
    {
        return new AuthenticationStorage(
            '7eelE1paJtbWvAKw0ROgVNLZak6rvEoD',
            '3333333333_01',
            'pass'
        );
    }
}
