<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;
use Apiboard\OpenAPI\Structure\Response;
use Apiboard\OpenAPI\Structure\Responses;

test('it can retrieve responses by their status code', function () {
    $pointer = new JsonPointer('/paths/my-uri/get/responses');
    $responses = new Responses([
        '200' => [],
    ], $pointer);

    $result = $responses['200'];

    expect($result)->toBeInstanceOf(Response::class);
    expect($result->pointer()->value())->toEqual('/paths/my-uri/get/responses/200');
});

test('it can retrieve referenced responses by their status code', function () {
    $responses = new Responses([
        '200' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $responses['200'];

    expect($result)->toBeInstanceOf(JsonReference::class);
});

test('it does not include vendor extensions', function () {
    $responses = new Responses([
        'x-vendor' => [],
    ]);

    $result = $responses['x-vendor'];

    expect($result)->toBeNull();
});

test('it can be constructed with array of response classes', function () {
    $responses = new Responses([
        new Response('200', []),
    ]);

    $result = $responses['200'];

    expect($result)->toBeInstanceOf(Response::class);
});
