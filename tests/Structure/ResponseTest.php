<?php

use Apiboard\OpenAPI\Structure\Headers;
use Apiboard\OpenAPI\Structure\Links;
use Apiboard\OpenAPI\Structure\MediaTypes;
use Apiboard\OpenAPI\Structure\Response;

test('it can return the status code', function () {
    $response = new Response('200', []);

    $result = $response->statusCode();

    expect($result)->toBe('200');
});

test('it can return the description', function () {
    $response = new Response('200', [
        'description' => 'My cool response',
    ]);

    $result = $response->description();

    expect($result)->toBe('My cool response');
});

test('it can return the headers', function () {
    $response = new Response('200', [
        'headers' => [],
    ]);

    $result = $response->headers();

    expect($result)->toBeInstanceOf(Headers::class);
});

test('it can return the content media types', function () {
    $response = new Response('200', [
        'content' => [],
    ]);

    $result = $response->content();

    expect($result)->toBeInstanceOf(MediaTypes::class);
});

test('it can return the links', function () {
    $response = new Response('200', [
        'links' => [],
    ]);

    $result = $response->links();

    expect($result)->toBeInstanceOf(Links::class);
});

test('it returns null when data is not available', function (string $data) {
    $response = new Response('200', []);

    $result = $response->{$data}();

    expect($result)->toBeNull();
})->with([
    'headers',
    'content',
    'links',
]);
