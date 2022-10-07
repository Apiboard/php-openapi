<?php

use Apiboard\OpenAPI\Structure\RequestBodies;
use Apiboard\OpenAPI\Structure\RequestBody;

test('it retrieve request bodies by key', function () {
    $requestBodies = new RequestBodies([
        0 => [],
    ]);

    $result = $requestBodies[0];

    expect($result)->toBeInstanceOf(RequestBody::class);
});

test('it can retrieve only required request bodies', function () {
    $requestBodies = new RequestBodies([
        [
            'required' => false,
        ],
        [
            'required' => true,
        ]
    ]);

    $result = $requestBodies->onlyRequired();

    expect($result)->toHaveCount(1);
    expect($result['1']->required())->toBeTrue();
});
