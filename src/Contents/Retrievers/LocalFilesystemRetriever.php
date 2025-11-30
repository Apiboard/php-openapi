<?php

namespace Apiboard\OpenAPI\Contents\Retrievers;

use Apiboard\OpenAPI\Contents\Contents;
use Apiboard\OpenAPI\Contents\Retriever;
use Symfony\Component\Filesystem\Path;

final class LocalFilesystemRetriever implements Retriever
{
    private string $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = dirname($basePath) . '/';
    }

    public function from(string $basePath): Retriever
    {
        return new LocalFilesystemRetriever($basePath);
    }

    public function retrieve(string $filePath): Contents
    {
        if (Path::isRelative($filePath)) {
            $filePath = Path::canonicalize($this->basePath . $filePath);
        }

        return new Contents(file_get_contents($filePath));
    }
}
