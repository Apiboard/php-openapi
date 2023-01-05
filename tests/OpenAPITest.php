<?php

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Reference;
use Apiboard\OpenAPI\Contents\Retriever;
use Apiboard\OpenAPI\Contents\Yaml;
use Apiboard\OpenAPI\Structure\Document;

test('it can build from JSON', function () {
    $jsonFile = fixture('example.json');

    $result = openAPI()->build($jsonFile);

    expect($result)->toBeInstanceOf(Document::class);
    expect(invade($result)->contents)->toBeInstanceOf(Json::class);
});

test('it can build from YAML', function () {
    $yamlFile = fixture('example.yaml');

    $result = openAPI()->build($yamlFile);

    expect($result)->toBeInstanceOf(Document::class);
    expect(invade($result)->contents)->toBeInstanceOf(Yaml::class);
});

test('it cannot build from invalid files', function () {
    $textFile = fixture('example.txt');

    openAPI()->build($textFile);
})->throws('Can only build JSON or YAML files');

test('it can validate OpenAPI specification v3.0.X', function () {
    $json = new Json('{
        "openapi": "3.0.0"
    }');

    $errors = openAPI()->validate($json);

    expect($errors)->toBe([
        '/info' => 'The property info is required',
        '/paths' => 'The property paths is required',
    ]);
});

test('it can resolve references', function () {
    $jsonFile = fixture('references.json');
    $retriever = new class () implements Retriever {
        private bool $called = false;

        public function retrieve(string $filePath): Json|Yaml
        {
            if (str_contains($filePath, 'references.json')) {
                return new Json(file_get_contents($filePath));
            }

            $this->called = true;

            return new Json('{ "description": "OK" }');
        }

        public function wasCalled(): bool
        {
            return $this->called;
        }
    };

    openAPI($retriever)->resolve(new Json(file_get_contents($jsonFile)));

    expect($retriever->wasCalled())->toBeTrue();
});

test('it resolves references when building', function () {
    $jsonFile = fixture('references.json');
    $retriever = new class () implements Retriever {
        private bool $called = false;

        public function retrieve(string $filePath): Json|Yaml
        {
            if (str_contains($filePath, 'references.json')) {
                return new Json(file_get_contents($filePath));
            }

            $this->called = true;

            return new Json('{ "description": "OK" }');
        }

        public function wasCalled(): bool
        {
            return $this->called;
        }
    };

    openAPI($retriever)->build($jsonFile);

    expect($retriever->wasCalled())->toBeTrue();
});

test('it can validate OpenAPI specification v3.1.X', function () {
    $yaml = new Yaml('openapi: 3.1.0');

    $errors = openAPI()->validate($yaml);

    expect($errors)->toBe([
        '/info' => 'The property info is required',
        '/paths' => 'The property paths is required',
        '/components' => 'The property components is required',
        '/webhooks' => 'The property webhooks is required',
    ]);
});

test('it cannot validate OpenAPI specification v2.X.X', function () {
    $yaml = new Yaml('openapi: 2.0.0');

    openAPI()->validate($yaml);
})->throws('Can only validate OpenAPI v3.0.X or v3.1.X');

test('it cannot validate OpenAPI specification v1.2', function () {
    $yaml = new Yaml('openapi: 1.2.0');

    openAPI()->validate($yaml);
})->throws('Can only validate OpenAPI v3.0.X or v3.1.X');

test('it throws when building invalid files', function () {
    $jsonFile = fixture('invalid.json');

    openAPI()->build($jsonFile);
})->throws('Can only validate OpenAPI v3.0.X or v3.1.X');

test('it throws when building incomplete files', function () {
    $jsonFile = fixture('incomplete.json');

    openAPI()->build($jsonFile);
})->throws('
The property info is required (~/info)
The property paths is required (~/paths)
The property components is required (~/components)
The property webhooks is required (~/webhooks)');
