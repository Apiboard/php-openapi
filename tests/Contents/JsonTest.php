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

test('casting JSON OAS contents to object casts empty schema keys from array to an object', function () {
    $json = new Json('{
        "some": {
            "key": [
                {
                    "schema": []
                }
            ]
        }
    }');

    $result = $json->toObject();

    expect($result->some->key[0]->schema)->toBeObject();
});

test('casting JSON OAS contents to object casts empty items keys from array to an object within an array typed schema definition', function () {
    $json = new Json('{
        "components": {
            "schemas": {
                "Something": {
                    "type": "array",
                    "items": []
                },
                "Else": {
                    "items": []
                }
            }
        }
    }');

    $result = $json->toObject();

    expect($result->components->schemas->Something->items)->toBeObject();
    expect($result->components->schemas->Else->items)->toBeArray();
});
