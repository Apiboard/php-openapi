<?php

use Apiboard\OpenAPI\Structure\Parameter;

test('it can return the name', function () {
    $parameter = new Parameter([
        'name' => 'Parameter name',
    ]);

    $result = $parameter->name();

    expect($result)->toBe('Parameter name');
});

test('it can return the description', function () {
    $parameter = new Parameter([
        'description' => 'Parameter description',
    ]);

    $result = $parameter->description();

    expect($result)->toBe('Parameter description');
});

test('it returns null when the description is unavailable', function () {
    $parameter = new Parameter([]);

    $result = $parameter->description();

    expect($result)->toBeNull();
});

test('it can return the location', function () {
    $parameter = new Parameter([
        'in' => 'header',
    ]);

    $result = $parameter->in();

    expect($result)->toBe('header');
});

test('it can return the deprecated state', function () {
    $parameter = new Parameter([
        'deprecated' => true,
    ]);

    $result = $parameter->deprecated();

    expect($result)->toBeTrue();
});

test('it returns false for the the deprecated state by default', function () {
    $parameter = new Parameter([
    ]);

    $result = $parameter->deprecated();

    expect($result)->toBeFalse();
});

test('it can return the style', function () {
    $parameter = new Parameter([
        'style' => 'form',
    ]);

    $result = $parameter->style();

    expect($result)->toBe('form');
});

test('it returns the default style for the location when not provided', function (string $location, string $style) {
    $parameter = new Parameter([
        'in' => $location,
    ]);

    $result = $parameter->style();

    expect($result)->toBe($style);
})->with([
    ['query', 'form'],
    ['path', 'simple'],
    ['header', 'simple'],
    ['cookie', 'form'],
]);

test('it can return the explode state', function () {
    $parameter = new Parameter([
        'explode' => true,
    ]);

    $result = $parameter->explode();

    expect($result)->toBeTrue();
});

test('it can return the default explode for the style', function (string $style, bool $explode) {
    $parameter = new Parameter([
        'style' => $style,
    ]);

    $result = $parameter->explode();

    expect($result)->toBe($explode);
})->with([
    ['form', true],
    ['simple', false],
]);

test('it can return if empty values are allowed', function () {
    $parameter = new Parameter([
        'allowEmptyValue' => true,
    ]);

    $result = $parameter->allowsEmptyValue();

    expect($result)->toBeTrue();
});

test('it returns false if empty value data is not available', function () {
    $parameter = new Parameter([]);

    $result = $parameter->allowsEmptyValue();

    expect($result)->toBeFalse();
});

test('it can return if reserved values are allowed', function () {
    $parameter = new Parameter([
        'allowReserved' => true,
    ]);

    $result = $parameter->allowsReserved();

    expect($result)->toBeTrue();
});

test('it returns false if reserved value data is not available', function () {
    $parameter = new Parameter([]);

    $result = $parameter->allowsReserved();

    expect($result)->toBeFalse();
});

test('it can return an example', function () {
    $parameter = new Parameter([
        'example' => 'value',
    ]);

    $result = $parameter->example();

    expect($result)->toBe('value');
});

test('it returns null when no example is available', function () {
    $parameter = new Parameter([]);

    $result = $parameter->example();

    expect($result)->toBeNull();
});
