<?php

use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Structure\Encoding;
use Apiboard\OpenAPI\Structure\Examples;
use Apiboard\OpenAPI\Structure\MediaType;
use Apiboard\OpenAPI\Structure\Schema;

test('it can return the schema', function () {
    $mediaType = new MediaType('application/json', [
        'schema' => [],
    ]);

    $result = $mediaType->schema();

    expect($result)->toBeInstanceOf(Schema::class);
});

test('it can return the referenced schema', function () {
    $mediaType = new MediaType('application/json', [
        'schema' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $mediaType->schema();

    expect($result)->toBeInstanceOf(Reference::class);
});

test('it can return the encoding', function () {
    $mediaType = new MediaType('application/json', [
        'encoding' => [
            'something' => [],
        ],
    ]);

    $result = $mediaType->encoding();

    expect($result)->toBeArray();
    expect($result['something'])->toBeInstanceOf(Encoding::class);
});

test('it can return the example', function () {
    $mediaType = new MediaType('application/json', [
        'example' => [],
    ]);

    $result = $mediaType->example();

    expect($result)->toBe([]);
});

test('it can return the examples', function () {
    $mediaType = new MediaType('application/json', [
        'examples' => [
            [],
        ],
    ]);

    $result = $mediaType->examples();

    expect($result)->toBeInstanceOf(Examples::class);
});

test('it can return the content type', function () {
    $mediaType = new MediaType('application/json', []);

    $result = $mediaType->contentType();

    expect($result)->toBe('application/json');
});

test('it return null when data is not available', function (string $data) {
    $mediaType = new MediaType('application/json', []);

    $result = $mediaType->{$data}();

    expect($result)->toBeNull();
})->with([
    'schema',
    'encoding',
    'example',
    'examples',
]);
