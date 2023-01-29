<?php

use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Structure\Schema;
use Apiboard\OpenAPI\Structure\Schemas;

test('it retrieve schemas by key', function () {
    $schemas = new Schemas([
        0 => [],
    ]);

    $result = $schemas[0];

    expect($result)->toBeInstanceOf(Schema::class);
});

test('it retrieve referenced schemas by key', function () {
    $schemas = new Schemas([
        0 => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $schemas[0];

    expect($result)->toBeInstanceOf(Reference::class);
});
