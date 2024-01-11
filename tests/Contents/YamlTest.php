<?php

use Apiboard\OpenAPI\Contents\Yaml;
use Apiboard\OpenAPI\References\JsonReference;

test('it can cast empty strings to an array', function () {
    $contents = '';

    $yaml = new Yaml($contents);

    expect($yaml->toArray())->toBeArray();
});

test('it can cast none empty YAML strings to an array', function () {
    $contents = <<<'EOD'
i-am:
    - not empty
    - it seems
EOD;

    $yaml = new Yaml($contents);

    expect($yaml->toArray())->toBe([
        'i-am' => [
            'not empty',
            'it seems',
        ],
    ]);
});

test('it can return all external references', function () {
    $json = new Yaml(<<<'EOD'
info:
  $ref: '#/some/internal-json-pointer'
paths:
  /:
    $ref: './some-externa-ref.yml'
EOD);

    $result = $json->references();

    expect($result)
        ->toHaveCount(2)
        ->toBeArrayOf(JsonReference::class);
});
