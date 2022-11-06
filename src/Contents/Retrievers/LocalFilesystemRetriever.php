<?php

namespace Apiboard\OpenAPI\Contents\Retrievers;

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Retriever;
use Apiboard\OpenAPI\Contents\Yaml;
use InvalidArgumentException;

final class LocalFilesystemRetriever implements Retriever
{
    public function retrieve(string $filePath): Json|Yaml
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        return match ($extension) {
            'json' => new Json(file_get_contents($filePath)),
            'yaml' => new Yaml(file_get_contents($filePath)),
            default => throw new InvalidArgumentException('Can only build JSON or YAML files'),
        };
    }
}
