<?php

use Apiboard\OpenAPI\Structure\DataTypes;
use Apiboard\OpenAPI\Structure\Examples;
use Apiboard\OpenAPI\Structure\Polymorphism;
use Apiboard\OpenAPI\Structure\Schema;

test('it can return the title', function () {
    $schema = new Schema([
        'title' => 'My schema title',
    ]);

    $result = $schema->title();

    expect($result)->toBe('My schema title');
});

test('it can return the description', function () {
    $schema = new Schema([
        'description' => 'My schema description',
    ]);

    $result = $schema->description();

    expect($result)->toBe('My schema description');
});

test('it can return the data types', function (array $data, int $count) {
    $schema = new Schema($data);

    $result = $schema->types();

    expect($result)
        ->toBeInstanceOf(DataTypes::class)
        ->toHaveCount($count);
})->with([
    'OpenAPI 3.0.X' =>[
        [
            'type' => 'string',
            'nullable' => false,
        ],
        1,
    ],
    'OpenAPI 3.1.X' => [
        [
            'type' => ['string']
        ],
        1
    ],
    'Nullable OpenAPI 3.0.X' => [
        [
            'type' => 'string',
            'nullable' => true,
        ],
        2
    ],
    'Nullable OpenAPI 3.1.X' => [
        [
            'type' => ['string', 'null'],
        ],
        2
    ]
]);

test('it can return the examples', function () {
    $schema = new Schema([
        'examples' => [],
    ]);

    $result = $schema->examples();

    expect($result)->toBeInstanceOf(Examples::class);
});

test('it can return the examples from a 3.0.X example format', function () {
    $schema = new Schema([
        'example' => 'An example!',
    ]);

    $result = $schema->examples();

    expect($result)->toBeInstanceOf(Examples::class);
    expect($result[0]->value())->toBe('An example!');
});

test('it can return the examples combined with a 3.0.X example format', function () {
    $schema = new Schema([
        'examples' => [
            [
                'value' => 'New example'
            ],
        ],
        'example' => 'An example!',
    ]);

    $result = $schema->examples();

    expect($result)
        ->toBeInstanceOf(Examples::class)
        ->toHaveCount(2);
});

test('it can return the deprecated state', function () {
    $schema = new Schema([
        'deprecated' => true,
    ]);

    $result = $schema->deprecated();

    expect($result)->toBeTrue();
});

test('it can return the read only state', function () {
    $schema = new Schema([
        'readOnly' => true,
    ]);

    $result = $schema->readOnly();

    expect($result)->toBeTrue();
});

test('it can return the write only state', function () {
    $schema = new Schema([
        'writeOnly' => true,
    ]);

    $result = $schema->writeOnly();

    expect($result)->toBeTrue();
});

test('it can return if is has polymorphism', function (string $morphKey) {
    $schema = new Schema([
        $morphKey => [],
    ]);

    $result = $schema->polymorphism();

    expect($result)->toBeInstanceOf(Polymorphism::class);
})->with([
    'allOf',
    'oneOf',
    'anyOf',
]);

test('it can return the default states when not available', function (string $state, bool $default) {
    $schema = new Schema([]);

    $result = $schema->{$state}();

    expect($result)->toBe($default);
})->with([
    ['deprecated', false],
    ['readOnly', false],
    ['writeOnly', false],
]);

test('it returns null when data is not available', function (string $data) {
    $schema = new Schema([]);

    $result = $schema->{$data}();

    expect($result)->toBeNull();
})->with([
   'title',
   'description',
   'examples',
   'polymorphism',
]);
