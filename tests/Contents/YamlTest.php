<?php

use Apiboard\OpenAPI\Contents\Yaml;

test('it can cast empty strings to an array', function () {
    $contents = "";

    $yaml = new Yaml($contents);

    expect($yaml->toArray())->toBeArray();
});

test('it can cast none empty YAML strings to an array', function () {
    $contents = <<<EOD
i-am:
    - not empty
    - it seems
EOD;

    $yaml = new Yaml($contents);

    expect($yaml->toArray())->toBe([
        'i-am' => [
            'not empty',
            'it seems',
        ]
    ]);
});
