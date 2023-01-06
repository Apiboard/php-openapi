<?php

use Apiboard\OpenAPI\Contents\JsonPointer;
use Apiboard\OpenAPI\Structure\Link;
use Apiboard\OpenAPI\Structure\RuntimeExpression;
use Apiboard\OpenAPI\Structure\Server;

test('it can return the description', function () {
    $link = new Link([
        'description' => 'My link!',
    ]);

    $result = $link->description();

    expect($result)->toBe('My link!');
});

test('it can return the operation id', function () {
    $link = new Link([
        'operationId' => 'operation-id',
    ]);

    $result = $link->operationId();

    expect($result)->toBe('operation-id');
});

test('it can return the operation reference', function () {
    $link = new Link([
        'operationRef' => '#/operation/ref',
    ]);

    $result = $link->operationRef();

    expect($result)->toBeInstanceOf(JsonPointer::class);
});

test('it can return the parameters', function () {
    $link = new Link([
        'parameters' => [
            'some' => 'expression',
        ],
    ]);

    $result = $link->parameters();

    expect($result)->toBeArray();
    expect($result['some'])->toBeInstanceOf(RuntimeExpression::class);
});

test('it can return the request body', function () {
    $link = new Link([
        'requestBody' => 'expression',
    ]);

    $result = $link->requestBody();

    expect($result)->toBeInstanceOf(RuntimeExpression::class);
});

test('it can return the server', function () {
    $link = new Link([
        'server' => [],
    ]);

    $result = $link->server();

    expect($result)->toBeInstanceOf(Server::class);
});

test('it can return null when data is not available', function (string $data) {
    $link = new Link([]);

    $result = $link->{$data}();

    expect($result)->toBeNull();
})->with([
    'operationId',
    'operationRef',
    'parameters',
    'requestBody',
    'description',
    'server',
]);
