<?php

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Yaml;
use Apiboard\OpenAPI\OpenAPI;
use Apiboard\OpenAPI\Structure\Specification;

test('it can parse from JSON', function () {
    $jsonFile = fixture('example.json');

    $result = OpenAPI::parse($jsonFile);

    expect($result)->toBeInstanceOf(Specification::class);
    expect(invade($result)->contents)->toBeInstanceOf(Json::class);
});

test('it can parse from YAML', function () {
    $yamlFile = fixture('example.yaml');

    $result = OpenAPI::parse($yamlFile);

    expect($result)->toBeInstanceOf(Specification::class);
    expect(invade($result)->contents)->toBeInstanceOf(Yaml::class);
});

test('it cannot parse from invalid files', function () {
    $textFile = fixture('example.txt');

    OpenAPI::parse($textFile);
})->throws(InvalidArgumentException::class);
