<?php

use Apiboard\OpenAPI\Structure\Parameter;
use Apiboard\OpenAPI\Structure\Parameters;

test('it retrieve parameters by key', function () {
    $parameters = new Parameters([
        0 => [],
    ]);

    $result = $parameters[0];

    expect($result)->toBeInstanceOf(Parameter::class);
});

test('it can retrieve parameter by their location', function (string $location) {
    $parameters = new Parameters([
        [
            'in' => $location,
        ],
    ]);
    $location = 'in' . ucfirst($location);

    $result = $parameters->{$location}();

    expect($result)
        ->toBeInstanceOf(Parameters::class)
        ->not->toBeEmpty()
    ;
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
    ]);

    $result = $parameters->onlyRequired();

    expect($result)->toHaveCount(1);
    expect($result[0]->required())->toBeTrue();
});
