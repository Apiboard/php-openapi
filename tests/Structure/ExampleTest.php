<?php

use Apiboard\OpenAPI\Structure\Example;

test('it can return the summary', function () {
    $example = new Example([
        'summary' => 'My cool example',
    ]);

    $result = $example->summary();

    expect($result)->toBe('My cool example');
});

test('it can return the value', function () {
    $example = new Example([
        'value' => [],
    ]);

    $result = $example->value();

    expect($result)->toBe([]);
});

test('it can return the external value', function () {
    $example = new Example([
        'externalValue' => 'some external value',
    ]);

    $result = $example->externalValue();

    expect($result)->toBe('some external value');
});

test('it returns null when data is not available', function (string $data) {
    $example = new Example([]);

    $result = $example->{$data}();

    expect($result)->toBeNull();
})->with([
    'summary',
    'description',
    'value',
    'externalValue',
]);
