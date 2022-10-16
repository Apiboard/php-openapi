<?php

use Apiboard\OpenAPI\Structure\Schema;
use Apiboard\OpenAPI\Structure\Schemas;

test('it retrieve schemas by key', function () {
    $schemas = new Schemas([
        0 => [],
    ]);

    $result = $schemas[0];

    expect($result)->toBeInstanceOf(Schema::class);
});

test('it can count the schemas', function () {
    $schemas = new Schemas([
        [],
    ]);

    expect($schemas)->toHaveCount(1);
});
