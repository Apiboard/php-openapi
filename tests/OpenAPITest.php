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
})->throws('Can only parse JSON or YAML files');

test('it can validate OpenAPI specification v3.0.X', function () {
    $json = new Json('{
        "openapi": "3.0.0"
    }');

    $errors = OpenAPI::validate($json);

    expect($errors)->toBe([
        '/info' => 'The property info is required',
        '/paths' => 'The property paths is required',
    ]);
});

test('it can validate OpenAPI specification v3.1.X', function () {
    $yaml = new Yaml('openapi: 3.1.0');

    $errors = OpenAPI::validate($yaml);

    expect($errors)->toBe([
        '/info' => 'The property info is required',
        '/paths' => 'The property paths is required',
        '/components' => 'The property components is required',
        '/webhooks' => 'The property webhooks is required',
    ]);
});

test('it cannot validate OpenAPI specification v2.X.X', function () {
    $yaml = new Yaml('openapi: 2.0.0');

    OpenAPI::validate($yaml);
})->throws('Can only validate OpenAPI v3.0.X or v3.1.X');

test('it cannot validate OpenAPI specification v1.2', function () {
    $yaml = new Yaml('openapi: 1.2.0');

    OpenAPI::validate($yaml);
})->throws('Can only validate OpenAPI v3.0.X or v3.1.X');

test('it throws when parsing invalid files', function () {
    $jsonFile = fixture('invalid.json');

    OpenAPI::parse($jsonFile);
})->throws('Can only validate OpenAPI v3.0.X or v3.1.X');

test('it throws when parsing incomplete files', function () {
    $jsonFile = fixture('incomplete.json');

    OpenAPI::parse($jsonFile);
})->throws('
The property info is required (~/info)
The property paths is required (~/paths)
The property components is required (~/components)
The property webhooks is required (~/webhooks)');
