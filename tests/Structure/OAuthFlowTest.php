<?php

use Apiboard\OpenAPI\Structure\OAuthFlow;

test('it can return the type', function () {
    $flow = new OAuthFlow('implicit', []);

    $result = $flow->type();

    expect($result)->toBe('implicit');
});

test('it can return the authorization url', function () {
    $flow = new OAuthFlow('implicit', [
        'authorizationUrl' => 'https://some.oauth.url/authorize',
    ]);

    $result = $flow->authorizationUrl();

    expect($result)->toBe('https://some.oauth.url/authorize');
});

test('it can return the token url', function () {
    $flow = new OAuthFlow('implicit', [
        'tokenUrl' => 'https://some.oauth.url/token',
    ]);

    $result = $flow->tokenUrl();

    expect($result)->toBe('https://some.oauth.url/token');
});

test('it can return the refresh url', function () {
    $flow = new OAuthFlow('implicit', [
        'refreshUrl' => 'https://some.oauth.url/refresh',
    ]);

    $result = $flow->refreshUrl();

    expect($result)->toBe('https://some.oauth.url/refresh');
});

test('it can return the scopes', function () {
    $flow = new OAuthFlow('implicit', [
        'scopes' => [],
    ]);

    $result = $flow->scopes();

    expect($result)->toBe([]);
});

test('it returns null when data is not available', function (string $data) {
    $flow = new OAuthFlow('implicit', []);

    $result = $flow->{$data}();

    expect($result)->toBeNull();
})->with([
    'authorizationUrl',
    'tokenUrl',
    'refreshUrl',
    'scopes',
]);
