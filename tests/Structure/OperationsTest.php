<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\Structure\Operation;
use Apiboard\OpenAPI\Structure\Operations;

test('it can retrieve operations by their method', function () {
    $pointer = new JsonPointer('/paths/something');
    $operations = new Operations([
        'get' => [],
    ], $pointer);

    $result = $operations['get'];

    expect($result)->toBeInstanceOf(Operation::class);
    expect($result->pointer()->value())->toEqual('/paths/something/get');
});

test('it returns null for unknown operation methods', function () {
    $operations = new Operations([]);

    $result = $operations['get'];

    expect($result)->toBeNull();
});
