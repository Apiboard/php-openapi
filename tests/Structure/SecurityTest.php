<?php

use Apiboard\OpenAPI\Structure\Security;
use Apiboard\OpenAPI\Structure\SecurityRequirement;

test('it can return security requirements by key', function () {
    $security = new Security([
        0 => [
            [
                'Something' => [],
            ],
        ],
    ]);

    $result = $security[0];

    expect($result)->toBeInstanceOf(SecurityRequirement::class);
});
