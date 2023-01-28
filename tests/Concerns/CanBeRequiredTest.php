<?php

use Apiboard\OpenAPI\Concerns\CanBeRequired;
use Apiboard\OpenAPI\Structure\Header;
use Apiboard\OpenAPI\Structure\Parameter;
use Apiboard\OpenAPI\Structure\RequestBody;

test('it can return the required state', function () {
    $class = new class () {
        use CanBeRequired;

        protected $data = [
            'required' => true,
        ];
    };

    $result = $class->required();

    expect($result)->toBeTrue();
});

test('it returns false for the the required state by default', function () {
    $class = new class () {
        use CanBeRequired;

        protected $data = [];
    };

    $result = $class->required();

    expect($result)->toBeFalse();
});

test('it is used in structure classes that can be required', function ($class) {
    $uses = class_uses($class);

    expect($uses)->toContain(CanBeRequired::class);
})->with([
    Header::class,
    Parameter::class,
    RequestBody::class,
]);
