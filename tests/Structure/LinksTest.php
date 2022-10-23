<?php

use Apiboard\OpenAPI\Contents\Reference;
use Apiboard\OpenAPI\Structure\Link;
use Apiboard\OpenAPI\Structure\Links;

test('it can retrieve links by their name', function () {
    $links = new Links([
        'my-link' => [],
    ]);

    $result = $links['my-link'];

    expect($result)->toBeInstanceOf(Link::class);
});

test('it can retrieve referenced links by their name', function () {
    $links = new Links([
        'my-link' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $links['my-link'];

    expect($result)->toBeInstanceOf(Reference::class);
});

test('it can return all its references', function () {
    $links = new Links([
        'my-link' => [
            '$ref' => '#/some/ref',
        ],
    ]);

    $result = $links->references();

    expect($result)->toHaveCount(1);
    expect($result[0])->toBeInstanceOf(Reference::class);
});
