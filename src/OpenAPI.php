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

        $errorMessage = '';

        foreach (self::validate($contents) as $pointer=>$error) {
            $errorMessage .= "\n" . $error . " (~{$pointer})";
        }

        if ($errorMessage) {
            throw new InvalidArgumentException($errorMessage);
        }

        return new Specification($contents);
    }

    public static function validate(Json|Yaml $contents): array
    {
        $version = match ($contents->toArray()['openapi'] ?? '') {
            '3.0.0', '3.0.1', '3.0.2', '3.0.3' => '3.0',
            '3.1.0' => '3.1',
            default => throw new InvalidArgumentException('Can only validate OpenAPI v3.0.X or v3.1.X'),
        };

        $schema = json_decode(file_get_contents(__DIR__ . "/Validation/v{$version}.json"));
        $structure = json_decode($contents->toString(), false, 512, JSON_FORCE_OBJECT | JSON_UNESCAPED_SLASHES);

        $validator = new \JsonSchema\Validator();
        $validator->validate($structure, $schema);

        $errors = array_reduce($validator->getErrors(), function (array $errors, array $error) {
            if ($error['pointer']) {
                $errors[$error['pointer']] = $error['message'];
            }

            return $errors;
        }, []);

        return $errors;
    }
}
