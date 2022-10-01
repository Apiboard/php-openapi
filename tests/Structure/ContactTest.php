<?php

use Apiboard\OpenAPI\Structure\Contact;

test('it can return the name', function () {
    $contact = new Contact([
        'name' => 'Jane Doe',
    ]);

    $result = $contact->name();

    expect($result)->toBe('Jane Doe');
});

test('it can return the url', function () {
    $contact = new Contact([
        'url' => 'https://example.com/contact',
    ]);

    $result = $contact->url();

    expect($result)->toBe('https://example.com/contact');
});

test('it can return the email', function () {
    $contact = new Contact([
        'email' => 'jane@example.com',
    ]);

    $result = $contact->email();

    expect($result)->toBe('jane@example.com');
});
