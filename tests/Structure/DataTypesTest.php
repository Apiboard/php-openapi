<?php

use Apiboard\OpenAPI\Structure\DataTypes;

test('it retrieve data types by key', function () {
    $dataTypes = new DataTypes([
        0 => 'object',
    ]);

    $result = $dataTypes[0];

    expect($result)->toBe('object');
});

test('it can count the data types', function () {
    $dataTypes = new DataTypes([
        'object'
    ]);

    expect($dataTypes)->toHaveCount(1);
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
