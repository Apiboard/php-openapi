<?php

use Apiboard\OpenAPI\Concerns\HasASchema;
use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\JsonReference;
use Apiboard\OpenAPI\Structure\Header;
use Apiboard\OpenAPI\Structure\Parameter;
use Apiboard\OpenAPI\Structure\Schema;

test('it can return the schema', function () {
    $class = new class () {
        use HasASchema;

        protected $data = [
            'schema' => [],
        ];

        protected JsonPointer $pointer;

        public function __construct()
        {
            $this->pointer = new JsonPointer('/my/pointer');
        }

        public function toArray(): array
        {
            return $this->data;
        }
    };

    $result = $class->schema();

    expect($result)->toBeInstanceOf(Schema::class);
    expect($result->pointer()->value())->toBe('/my/pointer/schema');
});

test('it can return a referenced schema', function () {
    $class = new class () {
        use HasASchema;

        protected $data = [
            'schema' => [
                '$ref' => '#/some/ref',
            ],
        ];

        public function toArray(): array
        {
            return $this->data;
        }
    };

    $result = $class->schema();

    expect($result)->toBeInstanceOf(JsonReference::class);
});

test('it is used in structure classes that have schemas', function ($class) {
    $uses = class_uses($class);

    expect($uses)->toContain(HasASchema::class);
})->with([
    Header::class,
    Parameter::class,
]);
