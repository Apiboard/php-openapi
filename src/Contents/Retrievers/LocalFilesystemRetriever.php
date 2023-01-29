<?php

namespace Apiboard\OpenAPI\Contents\Retrievers;

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Retriever;
use Apiboard\OpenAPI\Contents\Yaml;
use InvalidArgumentException;
use Symfony\Component\Filesystem\Path;

final class LocalFilesystemRetriever implements Retriever
{
    private string $basePath = '';

    public function basePath(): string
    {
        return $this->basePath;
    }

    public function from(string $basePath): Retriever
    {
        $this->basePath = dirname($basePath).'/';

        return $this;
    }

    public function retrieve(string $filePath): Json|Yaml
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        if (str_starts_with($filePath, '/') === false) {
            $filePath = Path::canonicalize($this->basePath.$filePath);
        }

        return match ($extension) {
            'json' => new Json(file_get_contents($filePath)),
            'yaml' => new Yaml(file_get_contents($filePath)),
            default => throw new InvalidArgumentException('Can only parse JSON or YAML files'),
        };
    }
}
