<?php

namespace Apiboard\OpenAPI;

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Retriever;
use Apiboard\OpenAPI\Contents\Retrievers\LocalFilesystemRetriever;
use Apiboard\OpenAPI\Contents\Yaml;
use Apiboard\OpenAPI\References\Resolver;
use Apiboard\OpenAPI\Structure\Document;
use InvalidArgumentException;

final class OpenAPI
{
    private Retriever $retriever;

    private Resolver $resolver;

    private \Opis\JsonSchema\Validator $validator;

    public function __construct(?Retriever $retriever = null)
    {
        $retriever = $retriever ?? new LocalFilesystemRetriever();

        $this->retriever = $retriever;
        $this->resolver = new Resolver($retriever);
        $this->validator = new \Opis\JsonSchema\Validator();
        $this->validator->resolver()
            ->registerFile('https://apiboard.dev/oas-3.0.json', __DIR__ . "/Validation/v3.0.json")
            ->registerFile('https://apiboard.dev/oas-3.1.json', __DIR__ . "/Validation/v3.1.json");
    }

    public function build(string $filePath): Document
    {
        $contents = $this->retriever->retrieve($filePath);

        $resolvedContents = $this->resolver->resolve($contents);

        $errorMessage = '';

        foreach ($this->validate($resolvedContents) as $pointer=>$errors) {
            foreach ($errors as $error) {
                $errorMessage .= "\n" . $error . " (~{$pointer})";
            }
        }

        if ($errorMessage) {
            throw new InvalidArgumentException($errorMessage);
        }

        return new Document($resolvedContents);
    }

    public function resolve(Json|Yaml $contents): Json|Yaml
    {
        return $this->resolver->resolve($contents);
    }

    public function validate(Json|Yaml $contents): array
    {
        $version = match ($contents->toArray()['openapi'] ?? '') {
            '3.0.0', '3.0.1', '3.0.2', '3.0.3' => '3.0',
            '3.1.0' => '3.1',
            default => throw new InvalidArgumentException('Can only validate OpenAPI v3.0.X or v3.1.X'),
        };

        $result = $this->validator->validate($contents->toObject(), "https://apiboard.dev/oas-{$version}.json");

        if ($result->isValid()) {
            return [];
        }

        return (new \Opis\JsonSchema\Errors\ErrorFormatter())->format($result->error());
    }
}
