<?php

namespace Apiboard\OpenAPI;

use Apiboard\OpenAPI\Contents\Contents;
use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Retriever;
use Apiboard\OpenAPI\Contents\Retrievers\FilesystemRetriever;
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
        $retriever = $retriever ?? new FilesystemRetriever();

        $this->retriever = $retriever;
        $this->resolver = new Resolver($retriever);
        $this->validator = $this->configureVanillaValidator();
    }

    public function parse(string $filePath): Document
    {
        $contents = $this->retrieve($filePath);

        $resolvedContents = $this->resolver->resolve($contents);

        $errorMessage = '';

        foreach ($this->validate($resolvedContents) as $pointer => $errors) {
            foreach ($errors as $error) {
                $errorMessage .= "\n" . $error . " (~{$pointer})";
            }
        }

        if ($errorMessage) {
            throw new InvalidArgumentException($errorMessage);
        }

        return new Document($resolvedContents);
    }

    public function resolve(string $filePath): Json|Yaml
    {
        $contents = $this->retrieve($filePath);

        return $this->resolver->resolve($contents);
    }

    public function validate(Json|Yaml $contents): array
    {
        $version = match ($contents->toArray()['openapi'] ?? '') {
            '3.0.0', '3.0.1', '3.0.2', '3.0.3' => '3.0',
            '3.1.0' => '3.1',
            default => throw new InvalidArgumentException('Can only validate OpenAPI v3.0.X or v3.1.X'),
        };

        $this->validator->setMaxErrors(10);
        $result = $this->validator->validate($contents->toObject(), "https://apiboard.dev/oas-{$version}.json");

        if ($result->isValid()) {
            return [];
        }

        return (new \Opis\JsonSchema\Errors\ErrorFormatter())->format($result->error());
    }

    private function retrieve(string $filePath): Json|Yaml|Contents
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        if (in_array($extension, ['json', 'yaml']) === false) {
            throw new InvalidArgumentException('Can only parse JSON or YAML files');
        }

        $contents = $this->retriever->from($filePath)->retrieve($filePath);

        return match (true) {
            $contents->isJson() => new Json($contents->toString()),
            $contents->isYaml() => new Yaml($contents->toString()),
            default => $contents,
        };
    }

    private function configureVanillaValidator(): \Opis\JsonSchema\Validator
    {
        $validator = new \Opis\JsonSchema\Validator();

        $validator->parser()
            ->setOption('allowFilters', false)
            ->setOption('allowMappers', false)
            ->setOption('allowTemplates', false)
            ->setOption('allowGlobals', false)
            ->setOption('allowDefaults', false)
            ->setOption('allowSlots', false)
            ->setOption('allowPragmas', false)
            ->setOption('allowDataKeyword', false)
            ->setOption('allowRelativeJsonPointerInRef', false)
            ->setOption('allowExclusiveMinMaxAsBool', false)
            ->setOption('keepDependenciesKeyword', false)
            ->setOption('keepAdditionalItemsKeyword', false);

        $validator->resolver()
            ->registerFile('https://apiboard.dev/oas-3.0.json', __DIR__ . '/Validation/v3.0.json')
            ->registerFile('https://apiboard.dev/oas-3.1.json', __DIR__ . '/Validation/v3.1.json');

        return $validator;
    }
}
