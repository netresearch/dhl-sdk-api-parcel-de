<?php

/**
 * See LICENSE file for license details.
 */

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Php84\Rector\FuncCall\AddEscapeArgumentRector;
use Rector\Php84\Rector\FuncCall\RoundingModeEnumRector;
use Rector\Php84\Rector\Param\ExplicitNullableParamTypeRector;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/test',
    ])
    // Target the lowest supported PHP version (composer: ^8.1) so Rector
    // does not rewrite code to syntax newer than the library supports.
    ->withPhpVersion(PhpVersion::PHP_81)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        earlyReturn: true,
        typeDeclarations: true,
        privatization: true
    )
    ->withPhpSets()
    ->withRules([
        ExplicitNullableParamTypeRector::class,
        AddEscapeArgumentRector::class,
        RoundingModeEnumRector::class,
    ])
    // Skip feature sets and rules that might cause issues
    ->withSkip([
        ReadOnlyPropertyRector::class,
        ClassPropertyAssignToConstructorPromotionRector::class,
        RemoveUnusedPrivatePropertyRector::class,
        RemoveEmptyClassMethodRector::class,
        RemoveUnusedPromotedPropertyRector::class
    ]);
