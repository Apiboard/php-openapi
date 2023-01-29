<?php

use Apiboard\OpenAPI\Structure\Components;
use Apiboard\OpenAPI\Structure\Info;
use Apiboard\OpenAPI\Structure\Paths;
use Apiboard\OpenAPI\Structure\Security;
use Apiboard\OpenAPI\Structure\Servers;
use Apiboard\OpenAPI\Structure\Tags;
use Apiboard\OpenAPI\Structure\Webhooks;

test('it can be cast to string', function () {
    $jsonSpec = jsonDocument('{}');
    $yamlSpec = yamlDocument('');

    expect((string) $jsonSpec)->toBe('{}');
    expect((string) $yamlSpec)->toBe('');
});

test('it can be cast to array', function () {
    $jsonSpec = jsonDocument('{}');
    $yamlSpec = yamlDocument('');

    expect($jsonSpec->toArray())->toBe([]);
    expect($yamlSpec->toArray())->toBe([]);
});

test('it can return the OpenAPI version', function () {
    $spec = jsonDocument('{
        "openapi": "3.1.0"
    }');

    $result = $spec->openAPI();

    expect($result)->toBe('3.1.0');
});

test('it can return the info', function () {
    $spec = jsonDocument('{
        "info": {
            "title": "Example API",
            "version": "0"
        }
    }');

    $result = $spec->info();

    expect($result)->toBeInstanceOf(Info::class);
});

test('it can return the paths', function () {
    $spec = jsonDocument('{
        "paths": {}
    }');

    $result = $spec->paths();

    expect($result)->toBeInstanceOf(Paths::class);
});

test('it can return the servers', function () {
    $spec = jsonDocument('{
        "servers": []
    }');

    $result = $spec->servers();

    expect($result)->toBeInstanceOf(Servers::class);
});

test('it can return the components', function () {
    $spec = jsonDocument('{
        "components": {}
    }');

    $result = $spec->components();

    expect($result)->toBeInstanceOf(Components::class);
});

test('it can return the security', function () {
    $spec = jsonDocument('{
        "security": {}
    }');

    $result = $spec->security();

    expect($result)->toBeInstanceOf(Security::class);
});

test('it can return the webhooks', function () {
    $spec = jsonDocument('{
        "webhooks": {}
    }');

    $result = $spec->webhooks();

    expect($result)->toBeInstanceOf(Webhooks::class);
});

test('it can return the tags', function () {
    $spec = jsonDocument('{
        "tags": []
    }');

    $result = $spec->tags();

    expect($result)->toBeInstanceOf(Tags::class);
});

test('it returns null when data is unavailable', function (string $data) {
    $spec = jsonDocument('{}');

    $result = $spec->{$data}();

    expect($result)->toBeNull();
})->with([
    'servers',
    'components',
    'security',
    'webhooks',
]);
