<?php

use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Structure\Response;
use Apiboard\OpenAPI\Structure\Responses;

test('it can retrieve responses by their status code', function () {
    $responses = new Responses([
        '200' => [],
    ]);

    $result = $responses['200'];

    expect($result)->toBeInstanceOf(Response::class);
});

test('it can retrieve referenced responses by their status code', function () {
    $responses = new Responses([
        '200' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $responses['200'];

    expect($result)->toBeInstanceOf(Reference::class);
});

test('it does not include vendor extensions', function () {
    $paths = new Responses([
        'x-vendor' => [],
    ]);

    $result = $paths['x-vendor'];

    expect($result)->toBeNull();
});
