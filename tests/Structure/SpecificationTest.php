<?php

use Apiboard\OpenAPI\Structure\Components;
use Apiboard\OpenAPI\Structure\Info;
use Apiboard\OpenAPI\Structure\Paths;
use Apiboard\OpenAPI\Structure\Security;
use Apiboard\OpenAPI\Structure\Servers;

test('it can be cast to string', function () {
    $jsonSpec = jsonSpecification('{}');
    $yamlSpec = yamlSpecification('');

    expect((string) $jsonSpec)->toBe('{}');
    expect((string) $yamlSpec)->toBe('');
});

test('it can be cast to array', function () {
    $jsonSpec = jsonSpecification('{}');
    $yamlSpec = yamlSpecification('');

    expect($jsonSpec->toArray())->toBe([]);
    expect($yamlSpec->toArray())->toBe([]);
});

test('it can return the OpenAPI version', function () {
    $spec = jsonSpecification('{
        "openapi": "3.1.0"
    }');

    $result = $spec->openAPI();

    expect($result)->toBe("3.1.0");
});

test('it can return the info', function () {
    $spec = jsonSpecification('{
        "info": {
            "title": "Example API",
            "version": "0"
        }
    }');

    $result = $spec->info();

    expect($result)->toBeInstanceOf(Info::class);
});

test('it can return the paths', function () {
    $spec = jsonSpecification('{
        "paths": {}
    }');

    $result = $spec->paths();

    expect($result)->toBeInstanceOf(Paths::class);
});

test('it can return the servers', function () {
    $spec = jsonSpecification('{
        "servers": []
    }');

    $result = $spec->servers();

    expect($result)->toBeInstanceOf(Servers::class);
});

test('it can return the components', function () {
    $spec = jsonSpecification('{
        "components": {}
    }');

    $result = $spec->components();

    expect($result)->toBeInstanceOf(Components::class);
});

test('it can return the security', function () {
    $spec = jsonSpecification('{
        "security": {}
    }');

    $result = $spec->security();

    expect($result)->toBeInstanceOf(Security::class);
});

test('it returns null when data is unavailable', function (string $data) {
    $spec = jsonSpecification('{}');

    $result = $spec->{$data}();

    expect($result)->toBeNull();
})->with([
    'servers',
    'components',
    'security',
]);
