<?php

use Apiboard\OpenAPI\Structure\Server;
use Apiboard\OpenAPI\Structure\ServerVariable;

test('it can return the url', function () {
    $server = new Server([
        'url' => 'https://my.server.example',
    ]);

    $result = $server->url();

    expect($result)->toBe('https://my.server.example');
});

test('it can return the description', function () {
    $server = new Server([
        'description' => 'My server!',
    ]);

    $result = $server->description();

    expect($result)->toBe('My server!');
});

test('it can return the server variables', function () {
    $server = new Server([
        'variables' => [
            [],
        ],
    ]);

    $result = $server->variables();

    expect($result)->toHaveCount(1);
    expect($result[0])->toBeInstanceOf(ServerVariable::class);
});

test('it return null when data is not available', function (string $data) {
    $server = new Server([]);

    $result = $server->{$data}();

    expect($result)->toBeNull();
})->with([
    'description',
    'variables',
]);
