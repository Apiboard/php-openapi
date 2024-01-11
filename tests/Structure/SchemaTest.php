<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\Reference;
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

test('it can return the data types', function (array $data, int $count) {
    $schema = new Schema($data);

    $result = $schema->types();

    expect($result)
        ->toBeInstanceOf(DataTypes::class)
        ->toHaveCount($count);
})->with([
    'OpenAPI 3.0.X' => [
        [
            'type' => 'string',
            'nullable' => false,
        ],
        1,
    ],
    'OpenAPI 3.1.X' => [
        [
            'type' => ['string'],
        ],
        1,
    ],
    'Nullable OpenAPI 3.0.X' => [
        [
            'type' => 'string',
            'nullable' => true,
        ],
        2,
    ],
    'Nullable OpenAPI 3.1.X' => [
        [
            'type' => ['string', 'null'],
        ],
        2,
    ],
]);

test('it can return the examples', function () {
    $pointer = new JsonPointer('/components/schemas/something');
    $schema = new Schema([
        'examples' => [],
    ], $pointer);

    $result = $schema->examples();

    expect($result)->toBeInstanceOf(Examples::class);
    expect($result->pointer()->value())->toBe('/components/schemas/something/examples');
});

test('it can return the examples from a 3.0.X example format', function () {
    $pointer = new JsonPointer('/components/schemas/something');
    $schema = new Schema([
        'example' => 'An example!',
    ], $pointer);

    $result = $schema->examples();

    expect($result)->toBeInstanceOf(Examples::class);
    expect($result->pointer()->value())->toBe('/components/schemas/something/example');
    expect($result[0]->value())->toBe('An example!');
});

test('it can return the examples combined with a 3.0.X example format', function () {
    $pointer = new JsonPointer('/components/schemas/something');
    $schema = new Schema([
        'examples' => [
            [
                'value' => 'New example',
            ],
        ],
        'example' => 'An example!',
    ], $pointer);

    $result = $schema->examples();

    expect($result)
        ->toBeInstanceOf(Examples::class)
        ->toHaveCount(2);
    expect($result->pointer()->value())->toBe('/components/schemas/something/examples');
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

test('it can return the properties', function () {
    $pointer = new JsonPointer('/components/schemas/something');
    $schema = new Schema([
        'properties' => [
            'something' => [],
        ],
    ], $pointer);

    $result = $schema->properties();

    expect($result)->toBeArray();
    expect($result['something'])->toBeInstanceOf(Schema::class);
    expect($result['something']->pointer()->value())->toBe('/components/schemas/something/properties/something');
});

test('it can return the items', function () {
    $pointer = new JsonPointer('/components/schemas/something');
    $schema = new Schema([
        'items' => [
            [],
        ],
    ], $pointer);

    $result = $schema->items();

    expect($result)->toBeInstanceOf(Schema::class);
    expect($result->pointer()->value())->toBe('/components/schemas/something/items');
});

test('it can return the items as reference', function () {
    $schema = new Schema([
        'items' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $schema->items();

    expect($result)->toBeInstanceOf(Reference::class);
});

test('it can return the min items', function () {
    $schema = new Schema([
        'minItems' => 1,
    ]);

    $result = $schema->minItems();

    expect($result)->toBe(1);
});

test('it can return the max items', function () {
    $schema = new Schema([
        'maxItems' => 1,
    ]);

    $result = $schema->maxItems();

    expect($result)->toBe(1);
});

test('it can return the unique items state', function () {
    $schema = new Schema([
        'uniqueItems' => true,
    ]);

    $result = $schema->uniqueItems();

    expect($result)->toBeTrue();
});

test('it can return the format', function () {
    $schema = new Schema([
        'format' => 'uuid',
    ]);

    $result = $schema->format();

    expect($result)->toBe('uuid');
});

test('it can return the enum', function () {
    $schema = new Schema([
        'enum' => ['one', 'two'],
    ]);

    $result = $schema->enum();

    expect($result)->toBe(['one', 'two']);
});

test('it can return the min length', function () {
    $schema = new Schema([
        'minLength' => 1,
    ]);

    $result = $schema->minLength();

    expect($result)->toBe(1);
});

test('it can return the minimum', function () {
    $schema = new Schema([
        'minimum' => 0,
    ]);

    $result = $schema->minimum();

    expect($result)->toBe(0);
});

test('it can return the max length', function () {
    $schema = new Schema([
        'maxLength' => 1,
    ]);

    $result = $schema->maxLength();

    expect($result)->toBe(1);
});

test('it can return the maximum', function () {
    $schema = new Schema([
        'maximum' => 0,
    ]);

    $result = $schema->maximum();

    expect($result)->toBe(0);
});

test('it can return the multiple of', function () {
    $schema = new Schema([
        'multipleOf' => 2,
    ]);

    $result = $schema->multipleOf();

    expect($result)->toBe(2);
});

test('it can return the required properties for objects', function () {
    $schema = new Schema([
        'required' => [
            'something',
        ],
    ]);

    $result = $schema->required();

    expect($result)->toBe([
        'something',
    ]);
});

test('it returns the required properties for objects as an empty array by default', function () {
    $schema = new Schema([
        'type' => 'object',
    ]);

    $result = $schema->required();

    expect($result)->toBe([]);
});

test('it can return the required state', function () {
    $schema = new Schema([
        'required' => true,
    ]);

    $result = $schema->required();

    expect($result)->toBeTrue();
});

test('it return the required state as false by default', function () {
    $schema = new Schema([]);

    $result = $schema->required();

    expect($result)->toBeFalse();
});

test('it can return if is has polymorphism', function (string $morphKey) {
    $pointer = new JsonPointer('/components/schemas/something');
    $schema = new Schema([
        $morphKey => [],
    ], $pointer);

    $result = $schema->polymorphism();

    expect($result)->toBeInstanceOf(Polymorphism::class);
    expect($result->pointer()->value())->toBe('/components/schemas/something/' . $morphKey);
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
    'types',
    'properties',
    'items',
    'format',
    'enum',
    'minimum',
    'maximum',
    'minItems',
    'maxItems',
    'uniqueItems',
    'multipleOf',
]);
