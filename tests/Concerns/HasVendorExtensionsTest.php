<?php

use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\Structure\Callbacks;
use Apiboard\OpenAPI\Structure\Components;
use Apiboard\OpenAPI\Structure\Contact;
use Apiboard\OpenAPI\Structure\Document;
use Apiboard\OpenAPI\Structure\Encoding;
use Apiboard\OpenAPI\Structure\Example;
use Apiboard\OpenAPI\Structure\Header;
use Apiboard\OpenAPI\Structure\Info;
use Apiboard\OpenAPI\Structure\License;
use Apiboard\OpenAPI\Structure\Link;
use Apiboard\OpenAPI\Structure\MediaType;
use Apiboard\OpenAPI\Structure\OAuthFlow;
use Apiboard\OpenAPI\Structure\OAuthFlows;
use Apiboard\OpenAPI\Structure\Operation;
use Apiboard\OpenAPI\Structure\Parameter;
use Apiboard\OpenAPI\Structure\PathItem;
use Apiboard\OpenAPI\Structure\Paths;
use Apiboard\OpenAPI\Structure\RequestBody;
use Apiboard\OpenAPI\Structure\Response;
use Apiboard\OpenAPI\Structure\Responses;
use Apiboard\OpenAPI\Structure\Schema;
use Apiboard\OpenAPI\Structure\SecurityScheme;
use Apiboard\OpenAPI\Structure\Server;
use Apiboard\OpenAPI\Structure\ServerVariable;
use Apiboard\OpenAPI\Structure\Tag;

test('it can retrieve vendor extensions', function () {
    $class = new class()
    {
        use HasVendorExtensions;

        protected $data = [
            'x-test' => true,
            'test' => false,
        ];
    };

    $result = $class->x('test');

    expect($result)->toBeTrue();
});

test('it is used in structure classes that can have vendor extensions', function ($class) {
    $uses = class_uses($class);

    expect($uses)->toContain(HasVendorExtensions::class);
})->with([
    Callbacks::class,
    Components::class,
    Contact::class,
    Document::class,
    Encoding::class,
    Example::class,
    Header::class,
    Info::class,
    License::class,
    Link::class,
    MediaType::class,
    OAuthFlow::class,
    OAuthFlows::class,
    Operation::class,
    Parameter::class,
    PathItem::class,
    Paths::class,
    RequestBody::class,
    Response::class,
    Responses::class,
    SecurityScheme::class,
    Server::class,
    ServerVariable::class,
    Schema::class,
    Tag::class,
]);
