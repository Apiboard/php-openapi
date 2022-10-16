<?php

use Apiboard\OpenAPI\Structure\Polymorphism;
use Apiboard\OpenAPI\Structure\Schemas;

test('it can return the type of polymorphism', function (string $type) {
    $polymorphism = new Polymorphism($type, [
        $type => [],
    ]);

    $result = $polymorphism->type();

    expect($result)->toBe($type);
})->with([
    'allOf',
    'anyOf',
    'oneOf',
]);

test('it can return the schemas for oneOf type', function () {
    $polymorphism = new Polymorphism('oneOf', [
        'oneOf' => [
            [],
            [],
        ]
    ]);

    $result = $polymorphism->schemas();

    expect($result)
        ->toBeInstanceOf(Schemas::class)
        ->toHaveCount(2);
});

test('it can return the schemas for anyOf type', function () {
    $polymorphism = new Polymorphism('anyOf', [
        'anyOf' => [
            [],
            [],
        ]
    ]);

    $result = $polymorphism->schemas();

    expect($result)
        ->toBeInstanceOf(Schemas::class)
        ->toHaveCount(2);
});

test('it can return the schemas for allOf type', function () {
    $polymorphism = new Polymorphism('allOf', [
        'allOf' => [
            [],
            [],
        ]
    ]);

    $result = $polymorphism->schemas();

    expect($result)
        ->toBeInstanceOf(Schemas::class)
        ->toHaveCount(1);
});
