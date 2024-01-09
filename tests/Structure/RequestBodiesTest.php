<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Structure\RequestBodies;
use Apiboard\OpenAPI\Structure\RequestBody;

test('it retrieve request bodies by key', function () {
    $pointer = new JsonPointer('/components/requestBodies');
    $requestBodies = new RequestBodies([
        0 => [],
    ], $pointer);

    $result = $requestBodies[0];

    expect($result)->toBeInstanceOf(RequestBody::class);
    expect($result->pointer()->value())->toEqual('/components/requestBodies/0');
});

test('it retrieve referenced request bodies by key', function () {
    $requestBodies = new RequestBodies([
        0 => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $requestBodies[0];

    expect($result)->toBeInstanceOf(Reference::class);
});

test('it can retrieve only required request bodies', function () {
    $requestBodies = new RequestBodies([
        [
            'required' => false,
        ],
        [
            'required' => true,
        ],
        [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $requestBodies->onlyRequired();

    expect($result)->toHaveCount(1);
    expect($result['1']->required())->toBeTrue();
});
