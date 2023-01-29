<?php

use Apiboard\OpenAPI\Structure\Tag;

test('it can return the name', function () {
    $tag = new Tag([
        'name' => 'My tag',
    ]);

    $result = $tag->name();

    expect($result)->toBe('My tag');
});
