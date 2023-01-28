<?php

use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Structure\Callbacks;
use Apiboard\OpenAPI\Structure\PathItem;

test('it can retrieve callbacks by their expression', function () {
    $callbacks = new Callbacks([
        'expression' => [],
    ]);

    $result = $callbacks['expression'];

    expect($result)->toBeInstanceOf(PathItem::class);
});

test('it can retrieve references callbacks by their expression', function () {
    $callbacks = new Callbacks([
        'expression' => [
            '$ref' => '#/some/ref'
        ],
    ]);

    $result = $callbacks['expression'];

    expect($result)->toBeInstanceOf(Reference::class);
});

test('it can be looped over', function () {
    $callbacks = new Callbacks([
        'expression-1' => [],
        'expression-2' => [],
    ]);
    $looped = [];

    foreach ($callbacks as $key=>$callback) {
        $looped[] = $key;

        expect($callback)->toBeInstanceOf(PathItem::class);
    }

    expect($looped)->toEqual([
        'expression-1',
        'expression-2',
    ]);
});
