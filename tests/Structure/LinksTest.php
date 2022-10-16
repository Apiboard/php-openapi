<?php

use Apiboard\OpenAPI\Structure\Link;
use Apiboard\OpenAPI\Structure\Links;

test('can be retrieved by their name', function () {
    $links = new Links([
        'my-link' => [],
    ]);

    $result = $links['my-link'];

    expect($result)->toBeInstanceOf(Link::class);
});
