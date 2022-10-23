<?php

use Apiboard\OpenAPI\Structure\Tag;

test('it can return the name', function () {
    $tag = new Tag([
        'name' => 'My tag',
    ]);

    $result = $tag->name();

    expect($result)->toBe('My tag');
});

test('it can return the description', function () {
    $tag = new Tag([
        'description' => 'My tag description',
    ]);

    $result = $tag->description();

    expect($result)->toBe('My tag description');
});

test('it returns null when the description is not available', function () {
    $tag = new Tag([]);

    $result = $tag->description();

    expect($result)->toBeNull();
});
