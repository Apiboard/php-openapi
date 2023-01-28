<?php

use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Structure\Example;
use Apiboard\OpenAPI\Structure\Examples;

test('it can retrieve examples by their key', function () {
    $examples = new Examples([
        'my-example' => []
    ]);

    $result = $examples['my-example'];

    expect($result)->toBeInstanceOf(Example::class);
});

test('it can retrieve referenced examples by their key', function () {
    $examples = new Examples([
        'my-example' => [
            '$ref' => '#/some/ref'
        ]
    ]);

    $result = $examples['my-example'];

    expect($result)->toBeInstanceOf(Reference::class);
});
