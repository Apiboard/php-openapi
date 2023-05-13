<?php

use Apiboard\OpenAPI\Structure\Security;
use Apiboard\OpenAPI\Structure\SecurityRequirement;

test('it can return security requirements by key', function () {
    $security = new Security([
        0 => [
            'Something' => [],
        ],
    ]);

    $result = $security[0];

    expect($result)->toBeInstanceOf(SecurityRequirement::class);
});

test('it can handle optional security requirements', function () {
    $security = new Security([
        0 => [
            'Something' => [],
        ],
        1 => [],
    ]);

    $result = $security[1];

    expect($result)->toBeInstanceOf(SecurityRequirement::class);
    expect($result->name())->toEqual('None');
});
