<?php

namespace Apiboard\OpenAPI;

use Apiboard\OpenAPI\Structure\Specification;
use Apiboard\OpenAPI\Support\Json;
use Apiboard\OpenAPI\Support\Yaml;
use InvalidArgumentException;

final class OpenAPI
{
    public static function parse(string $filePath): Specification
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        $parser = match ($extension) {
            'json' => new Json(file_get_contents($filePath)),
            'yaml' => new Yaml(file_get_contents($filePath)),
            default => throw new InvalidArgumentException('Can only parse JSON or YAML files'),
        };

        return new Specification($parser);
    }
}
