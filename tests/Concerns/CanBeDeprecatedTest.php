<?php

use Apiboard\OpenAPI\Concerns\CanBeDeprecated;
use Apiboard\OpenAPI\Structure\Header;
use Apiboard\OpenAPI\Structure\Operation;
use Apiboard\OpenAPI\Structure\Parameter;
use Apiboard\OpenAPI\Structure\Schema;

test('it can return the deprecated state', function () {
    $class = new class () {
        use CanBeDeprecated;

        protected $data = [
            'deprecated' => true,
        ];
    };

    $result = $class->deprecated();

    expect($result)->toBeTrue();
});

test('it returns false for the the deprecated state by default', function () {
    $class = new class () {
        use CanBeDeprecated;
    };

    $result = $class->deprecated();

    expect($result)->toBeFalse();
});

test('it is used in structure classes that can be deprecated', function ($class) {
    $uses = class_uses($class);

    expect($uses)->toContain(CanBeDeprecated::class);
})->with([
    Header::class,
    Operation::class,
    Parameter::class,
    Schema::class,
]);
