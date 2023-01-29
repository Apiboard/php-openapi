<?php

use Apiboard\OpenAPI\Structure\MediaTypes;
use Apiboard\OpenAPI\Structure\RequestBody;

test('it can return the content media types', function () {
    $requestBody = new RequestBody([
        'content' => [],
    ]);

    $result = $requestBody->content();

    expect($result)->toBeInstanceOf(MediaTypes::class);
});
