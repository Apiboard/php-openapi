<?php

use Apiboard\OpenAPI\Structure\MediaTypes;
use Apiboard\OpenAPI\Structure\RequestBody;

test('it can return the description', function () {
    $requestBody = new RequestBody([
        'description' => 'Some request body!',
    ]);

    $result = $requestBody->description();

    expect($result)->toBe('Some request body!');
});

test('it can return the content media types', function () {
    $requestBody = new RequestBody([
        'content' => [],
    ]);

    $result = $requestBody->content();

    expect($result)->toBeInstanceOf(MediaTypes::class);
});

test('it returns null when the description is not provided', function () {
    $requestBody = new RequestBody([]);

    $result = $requestBody->description();

    expect($result)->toBeNull();
});
