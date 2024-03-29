<?php

use Apiboard\OpenAPI\Structure\DataTypes;

test('it can return if the data type is string', function () {
    $dataTypes = new DataTypes([
        'string',
    ]);

    $result = $dataTypes->isString();

    expect($result)->toBeTrue();
});

test('it can return if the data type is number', function () {
    $dataTypes = new DataTypes([
        'number',
    ]);

    $result = $dataTypes->isNumber();

    expect($result)->toBeTrue();
});

test('it can return if the data type is integer', function () {
    $dataTypes = new DataTypes([
        'integer',
    ]);

    $result = $dataTypes->isInteger();

    expect($result)->toBeTrue();
});

test('it can return if the data type is object', function () {
    $dataTypes = new DataTypes([
        'object',
    ]);

    $result = $dataTypes->isObject();

    expect($result)->toBeTrue();
});

test('it can return if the data type is array', function () {
    $dataTypes = new DataTypes([
        'array',
    ]);

    $result = $dataTypes->isArray();

    expect($result)->toBeTrue();
});

test('it can return if the data type is nullable', function (array $types, bool $nullable) {
    $dataTypes = new DataTypes($types);

    $result = $dataTypes->isNullable();

    expect($result)->toBe($nullable);
})->with([
    [
        ['string', 'null'], true,
    ],
    [
        ['string'], false,
    ],
]);
