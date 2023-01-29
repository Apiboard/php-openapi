<?php

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Retriever;
use Apiboard\OpenAPI\Contents\Yaml;
use Apiboard\OpenAPI\Structure\Document;

test('it can parse from JSON', function () {
    $jsonFile = fixture('example.json');

    $result = openAPI()->parse($jsonFile);

    expect($result)->toBeInstanceOf(Document::class);
    expect(invade($result)->contents)->toBeInstanceOf(Json::class);
});

test('it can parse from YAML', function () {
    $yamlFile = fixture('example.yaml');

    $result = openAPI()->parse($yamlFile);

    expect($result)->toBeInstanceOf(Document::class);
    expect(invade($result)->contents)->toBeInstanceOf(Yaml::class);
});

test('it cannot parse from invalid files', function () {
    $textFile = fixture('example.txt');

    openAPI()->parse($textFile);
})->throws('Can only parse JSON or YAML files');

test('it can validate OpenAPI specification v3.0.X', function () {
    $json = new Json('{
        "openapi": "3.0.0"
    }');

    $errors = openAPI()->validate($json);

    expect($errors)->toBe([
        '/' => [
            'The required properties (info, paths) are missing',
        ],
    ]);
});

test('it can resolve references', function () {
    $jsonFile = fixture('references.json');
    $retriever = new class() implements Retriever
    {
        private bool $called = false;

        private string $basePath = '';

        public function basePath(): string
        {
            return $this->basePath;
        }

        public function from(string $basePath): self
        {
            $this->basePath = dirname($basePath);

            return $this;
        }

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

    openAPI($retriever)->resolve($jsonFile);

    expect($retriever->wasCalled())->toBeTrue();
});

test('it resolves references when parsing', function () {
    $jsonFile = fixture('references.json');
    $retriever = new class() implements Retriever
    {
        private bool $called = false;

        private string $basePath = '';

        public function basePath(): string
        {
            return $this->basePath;
        }

        public function from(string $basePath): self
        {
            $this->basePath = $basePath;

            return $this;
        }

        public function retrieve(string $filePath): Json|Yaml
        {
            if (str_ends_with($filePath, 'references.json')) {
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

    openAPI($retriever)->parse($jsonFile);

    expect($retriever->basePath())->toBe($jsonFile);
    expect($retriever->wasCalled())->toBeTrue();
});

test('it can validate OpenAPI specification v3.1.X', function () {
    $yaml = new Yaml('openapi: 3.1.0');

    $errors = openAPI()->validate($yaml);

    expect($errors)->toBe([
        '/' => [
            'The required properties (info) are missing',
        ],
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

test('it throws when parsing invalid files', function () {
    $jsonFile = fixture('invalid.json');

    openAPI()->parse($jsonFile);
})->throws('Can only validate OpenAPI v3.0.X or v3.1.X');

test('it throws when parsing incomplete files', function () {
    $jsonFile = fixture('incomplete.json');

    openAPI()->parse($jsonFile);
})->throws('The required properties (info) are missing (~/)');
