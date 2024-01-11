<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;
use Apiboard\OpenAPI\Structure\Example;
use Apiboard\OpenAPI\Structure\Examples;

test('it can retrieve examples by their key', function () {
    $pointer = new JsonPointer('/components/schemas/something/examples');
    $examples = new Examples([
        'my-example' => [],
    ], $pointer);

    $result = $examples['my-example'];

    expect($result)->toBeInstanceOf(Example::class);
    expect($result->pointer()->value())->toBe('/components/schemas/something/examples/my-example');
});

test('it can retrieve referenced examples by their key', function () {
    $examples = new Examples([
        'my-example' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $examples['my-example'];

    expect($result)->toBeInstanceOf(JsonReference::class);
});
