<?php

use Apiboard\OpenAPI\Structure\ServerVariable;

test('it can return the enum', function () {
    $serverVariable = new ServerVariable([
        'enum' => [
            'my-var',
        ],
    ]);

    $result = $serverVariable->enum();

    expect($result)->toBe([
        'my-var',
    ]);
});

test('it can return the default value', function () {
    $serverVariable = new ServerVariable([
        'default' => 'something',
    ]);

    $result = $serverVariable->default();

    expect($result)->toBe('something');
});

test('it can return the description', function () {
    $serverVariable = new ServerVariable([
        'description' => 'some variable',
    ]);

    $result = $serverVariable->description();

    expect($result)->toBe('some variable');
});

test('it can return null when data is not available', function (string $data) {
    $serverVariable = new ServerVariable([]);

    $result = $serverVariable->{$data}();

    expect($result)->toBeNull();
})->with([
    'enum',
    'description',
]);
