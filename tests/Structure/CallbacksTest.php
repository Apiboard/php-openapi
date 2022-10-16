<?php

use Apiboard\OpenAPI\Structure\Callbacks;
use Apiboard\OpenAPI\Structure\PathItem;

test('it can retrieve callbacks by their expression', function () {
    $callbacks = new Callbacks([
        'expression' => [],
    ]);

    $result = $callbacks['expression'];

    expect($result)->toBeInstanceOf(PathItem::class);
});
