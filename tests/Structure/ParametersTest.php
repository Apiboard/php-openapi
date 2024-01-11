<?php

use Apiboard\OpenAPI\References\JsonPointer;
use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Structure\Parameter;
use Apiboard\OpenAPI\Structure\Parameters;

test('it retrieve parameters by key', function () {
    $pointer = new JsonPointer('/paths/my-uri');
    $parameters = new Parameters([
        0 => [],
    ], $pointer);

    $result = $parameters[0];

    expect($result)->toBeInstanceOf(Parameter::class);
    expect($result->pointer()->value())->toBe('/paths/my-uri/0');
});

test('it can retrieve referenced parameters by key', function () {
    $parameters = new Parameters([
        0 => [
            '$ref' => '#/some/reference',
        ],
    ]);

    $result = $parameters[0];

    expect($result)->toBeInstanceOf(Reference::class);
});

test('it can retrieve parameter by their location', function (string $location) {
    $parameters = new Parameters([
        [
            'in' => $location,
        ],
        [
            '$ref' => '#/some/ref',
        ],
    ]);
    $location = 'in' . ucfirst($location);

    $result = $parameters->{$location}();

    expect($result)
        ->toBeInstanceOf(Parameters::class)
        ->not->toBeEmpty();
})->with([
    'query',
    'header',
    'path',
]);

test('it can retrieve only required parameters', function () {
    $parameters = new Parameters([
        [
            'required' => true,
        ],
        [
            'required' => false,
        ],
        [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $parameters->onlyRequired();

    expect($result)->toHaveCount(1);
    expect($result[0]->required())->toBeTrue();
});
