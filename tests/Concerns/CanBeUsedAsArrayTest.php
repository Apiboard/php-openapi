<?php

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\Structure\Callbacks;
use Apiboard\OpenAPI\Structure\DataTypes;
use Apiboard\OpenAPI\Structure\Examples;
use Apiboard\OpenAPI\Structure\Headers;
use Apiboard\OpenAPI\Structure\Links;
use Apiboard\OpenAPI\Structure\MediaTypes;
use Apiboard\OpenAPI\Structure\Operations;
use Apiboard\OpenAPI\Structure\Parameters;
use Apiboard\OpenAPI\Structure\Paths;
use Apiboard\OpenAPI\Structure\RequestBodies;
use Apiboard\OpenAPI\Structure\Responses;
use Apiboard\OpenAPI\Structure\Schemas;
use Apiboard\OpenAPI\Structure\Security;
use Apiboard\OpenAPI\Structure\SecuritySchemes;
use Apiboard\OpenAPI\Structure\Servers;
use Apiboard\OpenAPI\Structure\Tags;
use Apiboard\OpenAPI\Structure\Webhooks;

test('it can be looped over', function () {
    $class = new class() implements ArrayAccess, Countable, Iterator
    {
        use CanBeUsedAsArray;

        protected $data = [
            'property-1',
            'property-2',
        ];
    };
    $looped = [];

    foreach ($class as $value) {
        $looped[] = $value;
    }

    expect($looped)->toEqual([
        'property-1',
        'property-2',
    ]);
});

test('it can be counted', function () {
    $class = new class() implements ArrayAccess, Countable, Iterator
    {
        use CanBeUsedAsArray;

        protected $data = [
            'property-1',
            'property-2',
        ];
    };

    $result = count($class);

    expect($result)->toEqual(2);
});

test('it can retrieve data by key', function () {
    $class = new class() implements ArrayAccess, Countable, Iterator
    {
        use CanBeUsedAsArray;

        protected $data = [
            0 => 'key',
        ];
    };

    $result = $class[0];

    expect($result)->toBe('key');
});

test('it is used in structure classes that can be used as arrays', function ($class) {
    $uses = class_uses($class);
    $implements = class_implements($class);

    expect($uses)->toContain(CanBeUsedAsArray::class);
    expect($implements)->toContain(
        ArrayAccess::class,
        Countable::class,
        Iterator::class,
    );
})->with([
    Callbacks::class,
    DataTypes::class,
    Examples::class,
    Headers::class,
    Links::class,
    MediaTypes::class,
    Operations::class,
    Parameters::class,
    Paths::class,
    RequestBodies::class,
    Responses::class,
    Schemas::class,
    Security::class,
    SecuritySchemes::class,
    Servers::class,
    Tags::class,
    Webhooks::class,
]);
