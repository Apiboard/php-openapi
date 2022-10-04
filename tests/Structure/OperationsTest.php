<?php

use Apiboard\OpenAPI\Structure\Operation;
use Apiboard\OpenAPI\Structure\Operations;

test('it can retrieve operations by their method', function () {
    $operations = new Operations([
        'get' => [],
    ]);

    $result = $operations['get'];

    expect($result)->toBeInstanceOf(Operation::class);
});

test('it returns null for unknown operation methods', function () {
    $operations = new Operations([]);

    $result = $operations['get'];

    expect($result)->toBeNull();
});

test('operations can be counted', function () {
    $operations = new Operations([
        'get' => [],
        'post' => [],
    ]);

    $result = count($operations);

    expect($result)->toBe(2);
});
