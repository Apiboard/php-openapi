<?php

namespace Apiboard\OpenAPI\Contents\Retrievers;

use Apiboard\OpenAPI\Contents\Contents;
use Apiboard\OpenAPI\Contents\Retriever;
use Symfony\Component\Filesystem\Path;

final class LocalFilesystemRetriever implements Retriever
{
    private string $basePath = '';

    public function from(string $basePath): Retriever
    {
        $this->basePath = dirname($basePath) . '/';

        return $this;
    }

    public function retrieve(string $filePath): Contents
    {
        if (Path::isRelative($filePath)) {
            $filePath = Path::canonicalize($this->basePath . $filePath);
        }

        return new Contents(file_get_contents($filePath));
    }
}
