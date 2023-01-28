<?php

use Apiboard\OpenAPI\Concerns\HasReferences;
use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\References\Reference;
use Apiboard\OpenAPI\Contents\Yaml;
use Apiboard\OpenAPI\Structure\Callbacks;
use Apiboard\OpenAPI\Structure\Examples;
use Apiboard\OpenAPI\Structure\Headers;
use Apiboard\OpenAPI\Structure\Links;
use Apiboard\OpenAPI\Structure\MediaType;
use Apiboard\OpenAPI\Structure\Operation;
use Apiboard\OpenAPI\Structure\Parameters;
use Apiboard\OpenAPI\Structure\Paths;
use Apiboard\OpenAPI\Structure\RequestBodies;
use Apiboard\OpenAPI\Structure\Responses;
use Apiboard\OpenAPI\Structure\Schema;
use Apiboard\OpenAPI\Structure\Schemas;
use Apiboard\OpenAPI\Structure\SecuritySchemes;
use Apiboard\OpenAPI\Structure\Webhooks;

test('it can return all references', function () {
    $class = new class () {
        use HasReferences;

        public function toArray(): array
        {
            return [
                'ref-key' => [
                    '$ref' => '#/some/ref'
                ],
                'normal-key' => 'with value',
            ];
        }
    };

    $result = $class->references();

    expect($result)->toHaveCount(1);
    expect($result[0])->toBeInstanceOf(Reference::class);
});

test('it is used in structure classes that can have references', function ($class) {
    $uses = class_uses($class);

    expect($uses)->toContain(HasReferences::class);
})->with([
    Json::class,
    Yaml::class,
    Callbacks::class,
    Examples::class,
    Headers::class,
    Links::class,
    MediaType::class,
    Operation::class,
    Parameters::class,
    Paths::class,
    RequestBodies::class,
    Responses::class,
    Schema::class,
    Schemas::class,
    SecuritySchemes::class,
    Webhooks::class,
]);
