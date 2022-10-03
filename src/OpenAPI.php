<?php

namespace Apiboard\OpenAPI;

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Yaml;
use Apiboard\OpenAPI\Structure\Specification;
use InvalidArgumentException;

final class OpenAPI
{
    public static function parse(string $filePath): Specification
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        $contents = match ($extension) {
            'json' => new Json(file_get_contents($filePath)),
            'yaml' => new Yaml(file_get_contents($filePath)),
            default => throw new InvalidArgumentException('Can only parse JSON or YAML files'),
        };

        return new Specification($contents);
    }
}
