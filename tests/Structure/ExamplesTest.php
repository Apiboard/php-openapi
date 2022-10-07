<?php

use Apiboard\OpenAPI\Structure\Example;
use Apiboard\OpenAPI\Structure\Examples;

test('it can retrieve examples by their key', function () {
    $examples = new Examples([
        'my-example' => []
    ]);

    $result = $examples['my-example'];

    expect($result)->toBeInstanceOf(Example::class);
});
