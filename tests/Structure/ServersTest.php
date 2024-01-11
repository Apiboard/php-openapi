<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\Structure\Server;
use Apiboard\OpenAPI\Structure\Servers;

test('servers can be accessed by key', function () {
    $pointer = new JsonPointer('/servers');
    $servers = new Servers([
        0 => [],
    ], $pointer);

    $result = $servers[0];

    expect($result)->toBeInstanceOf(Server::class);
    expect($result->pointer()->value())->toBe('/servers/0');
});

test('it can be constructed with an array of servers', function () {
    $server = new Server([]);
    $servers = new Servers([
        $server,
    ]);

    $result = $servers[0];

    expect($result)->toEqual($server);
});
