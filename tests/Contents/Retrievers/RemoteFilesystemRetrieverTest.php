<?php

declare(strict_types=1);

use Apiboard\OpenAPI\Contents\Retrievers\RemoteFilesystemRetriever;
use phpmock\Mock;
use phpmock\MockBuilder;

$fileContentsMock = new class () {
    protected ?Mock $mock = null;

    protected array $called = [];

    protected array $contents = [];

    public function addContents(string $path, string $contents): self
    {
        $this->contents[$path] = $contents;

        return $this;
    }

    public function assertCalledWith(string $path): void
    {
        expect($this->called)->toContain($path);
    }

    public function __invoke($path)
    {
        $this->called[] = $path;

        return $this->contents[$path];
    }

    public function mock(): Mock
    {
        return $this->mock ??= (new MockBuilder())
            ->setNamespace('\Apiboard\OpenAPI\Contents\Retrievers')
            ->setName('file_get_contents')
            ->setFunction($this)
            ->build();
    }
};

beforeEach(fn () => $fileContentsMock->mock()->enable());

afterEach(fn () => $fileContentsMock->mock()->disable());

function remoteRetriever(string $url): RemoteFilesystemRetriever
{
    return new RemoteFilesystemRetriever($url);
}

test('it can retrieve files with urls', function () use ($fileContentsMock) {
    $url = 'https://example.com/api/spec.json';
    $fileContentsMock->addContents($url, 'the contents!');

    $result = remoteRetriever($url)->retrieve($url);

    $fileContentsMock->assertCalledWith($url);
    expect($result->toString())->toEqual('the contents!');
});

test('it can retrieve files with relative path using the configured base path', function () use ($fileContentsMock) {
    $baseUrl = 'https://example.com/api';
    $url = './other-spec.json';
    $fileContentsMock->addContents('https://example.com/api/other-spec.json', 'the contents!');

    $result = remoteRetriever($baseUrl)->retrieve($url);

    $fileContentsMock->assertCalledWith('https://example.com/api/other-spec.json');
    expect($result->toString())->toEqual('the contents!');
});

test('it can retrieve files with relative path using the configured base path with filename', function () use ($fileContentsMock) {
    $baseUrl = 'https://example.com/api/spec.json';
    $url = './other-spec.json';
    $fileContentsMock->addContents('https://example.com/api/other-spec.json', 'the contents!');

    $result = remoteRetriever($baseUrl)->retrieve($url);

    $fileContentsMock->assertCalledWith('https://example.com/api/other-spec.json');
    expect($result->toString())->toEqual('the contents!');
});
