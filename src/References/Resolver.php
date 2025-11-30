<?php

namespace Apiboard\OpenAPI\References;

use Apiboard\OpenAPI\Contents\Contents;
use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Retriever;
use Apiboard\OpenAPI\Contents\Yaml;

final class Resolver
{
    private ?Retriever $retriever;

    private array $cache;

    private ?Reference $parentReference;

    public function __construct(
        ?Retriever $retriever = null,
        array $cache = [],
        ?Reference $parentReference = null,
    ) {
        $this->retriever = $retriever;
        $this->cache = $cache;
        $this->parentReference = $parentReference;
    }

    public function resolve(Json|Yaml|Contents $contents): Json|Yaml|Contents
    {
        foreach ($contents->references() as $reference) {
            /** @var ?Contents $resolvedContent */
            $resolvedContent = match (true) {
                $this->pointsToVendorExtension($reference) => null,
                $reference->value()->isInternal() => $this->resolveInternalPointer($contents, $reference->value()->pointer()),
                default => $this->retrieveReference($reference->value()),
            };

            if ($resolvedContent === null) {
                continue;
            }

            if ($resolvedContent->isResolved() === false) {
                $resolver = new self(
                    $this->retriever->from($reference->value()->basePath()),
                    $this->cache,
                    $reference,
                );

                $resolvedContent = $resolver->resolve($resolvedContent);
            }

            $contents = $contents->replaceAt($reference->pointer(), $resolvedContent);
        }

        return $contents;
    }

    private function resolveInternalPointer(Json|Yaml|Contents $contents, JsonPointer $pointer): ?Contents
    {
        /** @var Contents $contents */
        $contents = $this->cache[$pointer->value()] ??= $contents->at($pointer);

        return $contents;
    }

    private function retrieveReference(JsonReference $jsonReference): ?Contents
    {
        /** @var ?Contents $contents */
        $contents = $this->cache[$jsonReference->path()] ??= $this->retriever?->retrieve($jsonReference->path());

        return $contents?->at($jsonReference->pointer());
    }

    private function pointsToVendorExtension(Reference $reference): bool
    {
        return str_contains($reference->pointer()->value(), 'x-');
    }
}
