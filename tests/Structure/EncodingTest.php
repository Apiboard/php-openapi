<?php

use Apiboard\OpenAPI\Structure\Encoding;
use Apiboard\OpenAPI\Structure\Headers;

test('it can return the content type', function () {
    $encoding = new Encoding([
        'contentType' => 'application/json',
    ]);

    $result = $encoding->contentType();

    expect($result)->toBe('application/json');
});

test('it can return the headers', function () {
    $encoding = new Encoding([
        'headers' => [],
    ]);

    $result = $encoding->headers();

    expect($result)->toBeInstanceOf(Headers::class);
});

test('it can return the explode state', function () {
    $parameter = new Encoding([
        'explode' => false,
    ]);

    $result = $parameter->explode();

    expect($result)->toBeFalse();
});

test('it can return the default explode for the style', function (string $style, bool $explode) {
    $parameter = new Encoding([
        'style' => $style,
    ]);

    $result = $parameter->explode();

    expect($result)->toBe($explode);
})->with([
    ['form', true],
    ['::anything-else::', false],
]);

test('it can return the style', function () {
    $encoding = new Encoding([
        'style' => 'spaceDelimited',
    ]);

    $result = $encoding->style();

    expect($result)->toBe('spaceDelimited');
});

test('it returns the default style when not provided', function () {
    $encoding = new Encoding([]);

    $result = $encoding->style();

    expect($result)->toBe('form');
});

test('it returns the default style if not available', function () {
    $encoding = new Encoding([]);

    $result = $encoding->style();

    expect($result)->toBe('form');
});

test('it can return if reserved values are allowed', function () {
    $parameter = new Encoding([
        'allowReserved' => true,
    ]);

    $result = $parameter->allowsReserved();

    expect($result)->toBeTrue();
});

test('it returns false if reserved value data is not available', function () {
    $parameter = new Encoding([]);

    $result = $parameter->allowsReserved();

    expect($result)->toBeFalse();
});

test('it returns null when data is unavailable', function (string $data) {
    $encoding = new Encoding([]);

    $result = $encoding->{$data}();

    expect($result)->toBeNull();
})->with([
    'contentType',
    'headers',
]);
