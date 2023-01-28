<?php

use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Structure\Callbacks;
use Apiboard\OpenAPI\Structure\Operation;
use Apiboard\OpenAPI\Structure\Parameters;
use Apiboard\OpenAPI\Structure\RequestBody;
use Apiboard\OpenAPI\Structure\Responses;
use Apiboard\OpenAPI\Structure\Security;
use Apiboard\OpenAPI\Structure\Servers;

test('it can return the method', function () {
    $operation = new Operation('get', []);

    $result = $operation->method();

    expect($result)->toBe('get');
});

test('it can return the summary', function () {
    $operation = new Operation('get', [
        'summary' => 'My get summary!'
    ]);

    $result = $operation->summary();

    expect($result)->toBe('My get summary!');
});

test('it can return the description', function () {
    $operation = new Operation('get', [
        'description' => 'My get description!'
    ]);

    $result = $operation->description();

    expect($result)->toBe('My get description!');
});

test('it can return the operationId', function () {
    $operation = new Operation('get', [
        'operationId' => 'my-get-operationId!'
    ]);

    $result = $operation->operationId();

    expect($result)->toBe('my-get-operationId!');
});

test('it can return the parameters', function () {
    $operation = new Operation('get', [
        'parameters' => []
    ]);

    $result = $operation->parameters();

    expect($result)->toBeInstanceOf(Parameters::class);
});

test('it can return the request body', function () {
    $operation = new Operation('get', [
        'requestBody' => []
    ]);

    $result = $operation->requestBody();

    expect($result)->toBeInstanceOf(RequestBody::class);
});

test('it can return the responses', function () {
    $operation = new Operation('get', [
        'responses' => []
    ]);

    $result = $operation->responses();

    expect($result)->toBeInstanceOf(Responses::class);
});

test('it can return the servers', function () {
    $operation = new Operation('get', [
        'servers' => []
    ]);

    $result = $operation->servers();

    expect($result)->toBeInstanceOf(Servers::class);
});

test('it can return the security', function () {
    $operation = new Operation('get', [
        'security' => []
    ]);

    $result = $operation->security();

    expect($result)->toBeInstanceOf(Security::class);
});

test('it can return the deprecated state', function () {
    $operation = new Operation('get', [
        'deprecated' => true
    ]);

    $result = $operation->deprecated();

    expect($result)->toBeTrue();
});

test('it returns false as deprecated state when not available', function () {
    $operation = new Operation('get', []);

    $result = $operation->deprecated();

    expect($result)->toBeFalse();
});


test('it can return the callbacks', function () {
    $operation = new Operation('get', [
        'callbacks' => [],
    ]);

    $result = $operation->callbacks();

    expect($result)->toBeInstanceOf(Callbacks::class);
});

test('it can return the tags', function () {
    $operation = new Operation('get', [
        'tags' => [
            'tag-1'
        ],
    ]);

    $result = $operation->tags();

    expect($result)->toBe([
        'tag-1',
    ]);
});

test('it returns null when data is unavailable', function (string $data) {
    $path = new Operation('get', []);

    $result = $path->{$data}();

    expect($result)->toBeNull();
})->with([
    'summary',
    'description',
    'operationId',
    'parameters',
    'requestBody',
    'servers',
    'security',
    'callbacks'
]);

test('it can return the referenced request body', function () {
    $operation = new Operation('get', [
        'requestBody' => [
            '$ref' => '#/some/ref'
        ]
    ]);

    $result = $operation->requestBody();

    expect($result)->toBeInstanceOf(Reference::class);
});
