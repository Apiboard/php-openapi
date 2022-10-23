<?php

use Apiboard\OpenAPI\Contents\Reference;
use Apiboard\OpenAPI\Structure\RequestBodies;
use Apiboard\OpenAPI\Structure\RequestBody;

test('it retrieve request bodies by key', function () {
    $requestBodies = new RequestBodies([
        0 => [],
    ]);

    $result = $requestBodies[0];

    expect($result)->toBeInstanceOf(RequestBody::class);
});

test('it retrieve referenced request bodies by key', function () {
    $requestBodies = new RequestBodies([
        0 => [
            '$ref' => '#/some/ref'
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
        ]
    ]);

    $result = $requestBodies->onlyRequired();

    expect($result)->toHaveCount(1);
    expect($result['1']->required())->toBeTrue();
});

test('it can return all its references', function () {
    $requestBodies = new RequestBodies([
        [],
        ['$ref' => '#/some/ref']
    ]);

    $result = $requestBodies->references();

    expect($result)->toHaveCount(1);
    expect($result[0])->toBeInstanceOf(Reference::class);
});
