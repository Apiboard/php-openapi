<?php

use Apiboard\OpenAPI\Structure\Header;

test('it can return the name', function () {
    $header = new Header('X-My-Header', []);

    $result = $header->name();

    expect($result)->toBe('X-My-Header');
});
