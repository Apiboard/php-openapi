<?php

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Reference;

test('it can cast empty strings to an array', function () {
    $contents = "";

    $json = new Json($contents);

    expect($json->toArray())->toBeArray();
});

test('it can cast empty JSON strings to an array', function () {
    $contents = "{}";

    $json = new Json($contents);

    expect($json->toArray())->toBeArray();
});

test('it can cast none empty JSON strings to an array', function () {
    $contents = '{"i-am": "not-empty"}';

    $json = new Json($contents);

    expect($json->toArray())->toBe([
        'i-am' => 'not-empty'
    ]);
});

test('it can cast an empty JSON string to an object', function () {
    $contents = '{}';

    $json = new Json($contents);

    expect($json->toObject())->toBeObject();
});

test('it can cast none empty JSON strings to an object', function () {
    $contents = '{"am": "not-empty"}';

    $json = new Json($contents);

    tap($json->toObject(), function (stdClass $object) {
        expect($object->am)->toBe('not-empty');
    });
});

test('it throws an exception on invalid json strings', function () {
    $contents = 'I am not in a JSON format!';

    $json = new Json($contents);

    $json->toArray();
})->throws(JsonException::class);

test('it can return all external references', function () {
    $json = new Json('{
        "info": {
            "$ref": "#/some-json-pointer"
        },
        "paths": {
           "/": {
                "$ref": "./some-external-ref.json"
           }
        }
    }');

    $result = $json->references();

    expect($result)
        ->toHaveCount(2)
        ->toBeArrayOf(Reference::class);
});

test('casting JSON OAS contents to object casts tags key to array and not an object', function () {
    $json = new Json('{
        "tags": {},
        "paths": {
            "something": {
                "tags": {
                    "0": {
                        "name": "test",
                        "description": "a test description"
                    }
                }
            }
        }
    }');

    $result = $json->toObject();

    expect($result->tags)->toBeArray();
    expect($result->paths->something->tags)->toBeArray();
    expect($result->paths->something->tags[0])->toBeObject();
});

test('casting JSON OAS contents to object casts security key to array and not an object', function () {
    $json = new Json('{
        "security": {},
        "paths": {
            "something": {
                "security": {
                    "0": {
                        "Bearer": {
                            "0": "scope-1"
                        }
                    }
                }
            }
        }
    }');

    $result = $json->toObject();

    expect($result->security)->toBeArray();
    expect($result->paths->something->security)->toBeArray();
    expect($result->paths->something->security[0])->toBeObject();
    expect($result->paths->something->security[0]->Bearer)->toBeArray();
});
