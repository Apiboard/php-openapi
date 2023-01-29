<?php

use Apiboard\OpenAPI\Structure\Operations;
use Apiboard\OpenAPI\Structure\Parameters;
use Apiboard\OpenAPI\Structure\PathItem;
use Apiboard\OpenAPI\Structure\Servers;

test('it can return the uri', function () {
    $path = new PathItem('/my-uri', []);

    $result = $path->uri();

    expect($result)->toBe('/my-uri');
});

test('it can return the summary', function () {
    $path = new PathItem('/my-uri', [
        'summary' => 'My uri summary!',
    ]);

    $result = $path->summary();

    expect($result)->toBe('My uri summary!');
});

test('it can return the parameters', function () {
    $path = new PathItem('/my-uri', [
        'parameters' => [],
    ]);

    $result = $path->parameters();

    expect($result)->toBeInstanceOf(Parameters::class);
});

test('it can return the servers', function () {
    $path = new PathItem('/my-uri', [
        'servers' => [],
    ]);

    $result = $path->servers();

    expect($result)->toBeInstanceOf(Servers::class);
});

test('it can return the operations', function () {
    $path = new PathItem('/my-uri', [
        'get' => [],
        'post' => [],
        'put' => [],
        'patch' => [],
        'delete' => [],
    ]);

    $result = $path->operations();

    expect($result)
        ->toBeInstanceOf(Operations::class)
        ->toHaveCount(5);
    expect($result['get'])->not->toBeNull();
});

test('it returns null when data is unavailable', function (string $data) {
    $path = new PathItem('/my-uri', []);

    $result = $path->{$data}();

    expect($result)->toBeNull();
})->with([
    'summary',
    'description',
    'operations',
    'servers',
    'parameters',
]);
