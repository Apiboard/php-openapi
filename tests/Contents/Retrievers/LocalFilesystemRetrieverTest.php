<?php

use Apiboard\OpenAPI\Contents\Retrievers\LocalFilesystemRetriever;

test('it can retrieve files with absolute paths', function () {
    $path = fixture('example.json');

    $result = localRetriever($path)->retrieve($path);

    expect($result->toString())->toBe(trim(file_get_contents($path)));
});

test('it can retrieve files with relative path using the configured base path', function () {
    $path = fixture('example.json');

    $result = localRetriever($path)->from($path)->retrieve('./example.json');

    expect($result->toString())->toBe(trim(file_get_contents($path)));
});

function localRetriever(string $path): LocalFilesystemRetriever
{
    return new LocalFilesystemRetriever($path);
}
