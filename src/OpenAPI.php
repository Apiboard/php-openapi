<?php

namespace Apiboard\OpenAPI;

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Yaml;
use Apiboard\OpenAPI\References\Resolver;
use Apiboard\OpenAPI\References\Retriever;
use Apiboard\OpenAPI\Structure\Specification;
use InvalidArgumentException;

final class OpenAPI
{
    private Resolver $resolver;

    private \JsonSchema\Validator $validator;

    public function __construct(?Retriever $referenceRetriever = null)
    {
        $this->resolver = new Resolver($referenceRetriever);
        $this->validator = new \JsonSchema\Validator();
    }

    public function build(string $filePath): Specification
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        $contents = match ($extension) {
            'json' => new Json(file_get_contents($filePath)),
            'yaml' => new Yaml(file_get_contents($filePath)),
            default => throw new InvalidArgumentException('Can only build JSON or YAML files'),
        };

        $resolvedContents = $this->resolver->resolve($contents);

        $errorMessage = '';

        foreach ($this->validate($resolvedContents) as $pointer=>$error) {
            $errorMessage .= "\n" . $error . " (~{$pointer})";
        }

        if ($errorMessage) {
            throw new InvalidArgumentException($errorMessage);
        }

        return new Specification($resolvedContents);
    }

    public function validate(Json|Yaml $contents): array
    {
        $version = match ($contents->toArray()['openapi'] ?? '') {
            '3.0.0', '3.0.1', '3.0.2', '3.0.3' => '3.0',
            '3.1.0' => '3.1',
            default => throw new InvalidArgumentException('Can only validate OpenAPI v3.0.X or v3.1.X'),
        };

        $schema = new Json(file_get_contents(__DIR__ . "/Validation/v{$version}.json"));
        $structure = $contents->toObject();

        $this->validator->validate($structure, $schema->toObject());

        $errors = array_reduce($this->validator->getErrors(), function (array $errors, array $error) {
            if ($error['pointer']) {
                $errors[$error['pointer']] = $error['message'];
            }

            return $errors;
        }, []);

        return $errors;
    }
}
