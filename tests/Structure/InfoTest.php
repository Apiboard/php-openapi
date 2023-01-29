<?php

use Apiboard\OpenAPI\Structure\Contact;
use Apiboard\OpenAPI\Structure\Info;
use Apiboard\OpenAPI\Structure\License;

test('it can return the title', function () {
    $info = new Info([
        'title' => 'Example API',
    ]);

    $result = $info->title();

    expect($result)->toBe('Example API');
});

test('it can return the version', function () {
    $info = new Info([
        'version' => '0',
    ]);

    $result = $info->version();

    expect($result)->toBe('0');
});

test('it can return the terms of service', function () {
    $info = new Info([
        'termsOfService' => 'https://example.com/terms',
    ]);

    $result = $info->termsOfService();

    expect($result)->toBe('https://example.com/terms');
});

test('it can return the license', function () {
    $info = new Info([
        'license' => [],
    ]);

    $result = $info->license();

    expect($result)->toBeInstanceOf(License::class);
});

test('it can return the contact information', function () {
    $info = new Info([
        'contact' => [],
    ]);

    $result = $info->contact();

    expect($result)->toBeInstanceOf(Contact::class);
});
