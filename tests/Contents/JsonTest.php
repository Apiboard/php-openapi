<?php

use Apiboard\OpenAPI\Contents\Json;

test('it can cast empty strings to an array', function () {
    $contents = "";

    $json = new Json($contents);

    expect($json->toArray())->toBeArray();
});

test('it can cast empty JSON strings to an array', function () {
    $contents = "{}";

    $json = new Json($contents);

    expect($json->toArray())->toBeArray();
});

test('it can cast none empty JSON strings to an array', function () {
    $contents = '{"i-am": "not-empty"}';

    $json = new Json($contents);

    expect($json->toArray())->toBe([
        'i-am' => 'not-empty'
    ]);
});

test('it throws an exception on invalid json strings', function () {
    $contents = 'I am not in a JSON format!';

    $json = new Json($contents);

    $json->toArray();
})->throws(JsonException::class);
