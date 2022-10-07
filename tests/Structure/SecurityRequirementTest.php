<?php

use Apiboard\OpenAPI\Structure\SecurityRequirement;

test('it can return the name', function () {
    $securityRequirement = new SecurityRequirement('AccessToken', [
    ]);

    $result = $securityRequirement->name();

    expect($result)->toBe('AccessToken');
});

test('it can return the scopes', function () {
    $securityRequirement = new SecurityRequirement('AccessToken', [
        'read:something',
    ]);

    $result = $securityRequirement->scopes();

    expect($result)->toBe([
        'read:something',
    ]);
});
