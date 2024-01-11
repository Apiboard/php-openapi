<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\Structure\MediaTypes;
use Apiboard\OpenAPI\Structure\RequestBody;

test('it can return the content media types', function () {
    $pointer = new JsonPointer('/paths/my-uri/get/requestBody');
    $requestBody = new RequestBody([
        'content' => [],
    ], $pointer);

    $result = $requestBody->content();

    expect($result)->toBeInstanceOf(MediaTypes::class);
    expect($result->pointer()->value())->toEqual('/paths/my-uri/get/requestBody/content');
});
