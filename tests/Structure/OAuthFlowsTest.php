<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\Structure\OAuthFlow;
use Apiboard\OpenAPI\Structure\OAuthFlows;

$supportedFlows = [
    'implicit',
    'password',
    'clientCredentials',
    'authorizationCode',
];

test('it can return the supported flows by name', function (string $name) {
    $pointer = new JsonPointer('/components/securitySchemes');
    $flows = new OAuthFlows([
        $name => [],
    ], $pointer);

    $result = $flows->{$name}();

    expect($result)->toBeInstanceOf(OAuthFlow::class);
    expect($result->pointer()->value())->toBe('/components/securitySchemes/' . $name);
})->with($supportedFlows);

test('it returns null when data is not available', function (string $data) {
    $flows = new OAuthFlows([]);

    $result = $flows->{$data}();

    expect($result)->toBeNull();
})->with($supportedFlows);
