<?php

use Apiboard\OpenAPI\Structure\Response;
use Apiboard\OpenAPI\Structure\Responses;

test('it can retrieve responses by their status code', function () {
    $responses = new Responses([
        '200' => [],
    ]);

    $result = $responses['200'];

    expect($result)->toBeInstanceOf(Response::class);
});
