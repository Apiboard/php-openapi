<?php

use Apiboard\OpenAPI\Contents\Reference;
use Apiboard\OpenAPI\Structure\Response;
use Apiboard\OpenAPI\Structure\Responses;

test('it can retrieve responses by their status code', function () {
    $responses = new Responses([
        '200' => [],
    ]);

    $result = $responses['200'];

    expect($result)->toBeInstanceOf(Response::class);
});

test('it can retrieve referenced responses by their status code', function () {
    $responses = new Responses([
        '200' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $responses['200'];

    expect($result)->toBeInstanceOf(Reference::class);
});

test('it can return all its references', function () {
    $responses = new Responses([
        "200" => [],
        "404" => ['$ref' => '#/some/ref']
    ]);

    $result = $responses->references();

    expect($result)->toHaveCount(1);
    expect($result[0])->toBeInstanceOf(Reference::class);
});
