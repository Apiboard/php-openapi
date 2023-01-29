<?php

use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Structure\Example;
use Apiboard\OpenAPI\Structure\Header;
use Apiboard\OpenAPI\Structure\Info;
use Apiboard\OpenAPI\Structure\Link;
use Apiboard\OpenAPI\Structure\Operation;
use Apiboard\OpenAPI\Structure\Parameter;
use Apiboard\OpenAPI\Structure\PathItem;
use Apiboard\OpenAPI\Structure\RequestBody;
use Apiboard\OpenAPI\Structure\Schema;
use Apiboard\OpenAPI\Structure\Server;
use Apiboard\OpenAPI\Structure\ServerVariable;
use Apiboard\OpenAPI\Structure\Tag;

test('it can return the description', function () {
    $class = new class()
    {
        use CanBeDescribed;

        protected $data = [
            'description' => 'The description',
        ];
    };

    $result = $class->description();

    expect($result)->toBe('The description');
});

test('it returns null when description is unavaible', function () {
    $class = new class()
    {
        use CanBeDescribed;
    };

    $result = $class->description();

    expect($result)->toBeNull();
});

test('it is used in structure classes that can be described', function ($class) {
    $uses = class_uses($class);

    expect($uses)->toContain(CanBeDescribed::class);
})->with([
    Example::class,
    Header::class,
    Info::class,
    Link::class,
    Operation::class,
    Parameter::class,
    PathItem::class,
    RequestBody::class,
    Schema::class,
    Server::class,
    ServerVariable::class,
    Tag::class,
]);
