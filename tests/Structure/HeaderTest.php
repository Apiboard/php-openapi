<?php

use Apiboard\OpenAPI\Structure\Header;

test('it can return the name', function () {
    $header = new Header('X-My-Header', []);

    $result = $header->name();

    expect($result)->toBe('X-My-Header');
});

test('it can return the description', function () {
    $header = new Header('X-My-Header', [
        'description' => 'My custom header!'
    ]);

    $result = $header->description();

    expect($result)->toBe('My custom header!');
});

test('it returns null when description is unavaible', function () {
    $header = new Header('X-My-Header', []);

    $result = $header->description();

    expect($result)->toBeNull();
});

test('it can return the required state', function () {
    $header = new Header('X-My-Header', [
        'required' => true,
    ]);

    $result = $header->required();

    expect($result)->toBeTrue();
});

test('it returns false for the the required state by default', function () {
    $header = new Header('X-My-Header', []);

    $result = $header->required();

    expect($result)->toBeFalse();
});

test('it can return the deprecated state', function () {
    $header = new Header('X-My-Header', [
        'deprecated' => true,
    ]);

    $result = $header->deprecated();

    expect($result)->toBeTrue();
});

test('it returns false for the the deprecated state by default', function () {
    $header = new Header('X-My-Header', []);

    $result = $header->deprecated();

    expect($result)->toBeFalse();
});
