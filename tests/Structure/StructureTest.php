<?php

use Apiboard\OpenAPI\Structure\Document;
use Apiboard\OpenAPI\Structure\RuntimeExpression;
use Apiboard\OpenAPI\Structure\Structure;

test('it can be json serialized', function () {
    $class = new class([]) extends Structure
    {
    };

    expect($class->jsonSerialize())->toBe([]);
});

test('it is used as parent where applicable', function (string $class) {
    $parent = get_parent_class($class);

    expect($parent)->toBe(Structure::class);
})->with(function () {
    $excluded = [
        Document::class,
        RuntimeExpression::class,
        Structure::class,
    ];

    foreach (scandir('src/Structure') as $fileName) {
        if ($fileName === '.') {
            continue;
        }

        if ($fileName === '..') {
            continue;
        }

        $class = 'Apiboard\\OpenAPI\\Structure\\'.$className = str_replace('.php', '', $fileName);

        if (in_array($class, $excluded)) {
            continue;
        }

        yield $className => $class;
    }
});
