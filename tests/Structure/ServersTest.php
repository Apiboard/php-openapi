<?php

use Apiboard\OpenAPI\Structure\Server;
use Apiboard\OpenAPI\Structure\Servers;

test('it can retrieve servers by key', function () {
    $servers = new Servers([
        0 => [],
    ]);

    $result = $servers[0];

    expect($result)->toBeInstanceOf(Server::class);
});
