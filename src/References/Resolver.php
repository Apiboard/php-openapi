<?php

namespace Apiboard\OpenAPI\References;

use Apiboard\OpenAPI\Contents\Contents;
use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Retriever;
use Apiboard\OpenAPI\Contents\Yaml;

final class Resolver
{
    private ?Retriever $retriever;

    private array $cache = [];

    private int $depth = 0;

    private array $recursiveReferences = [];

    private Json|Yaml|Contents|null $contents = null;

    private ?Reference $parentReference = null;

    public function __construct(?Retriever $retriever = null)
    {
        $this->retriever = $retriever;
    }

    public function resolve(Json|Yaml|Contents $contents): Json|Yaml|Contents
    {
        if ($this->contents === null) {
            $this->contents = $contents;
        }

        foreach ($contents->references() as $reference) {
            /** @var ?Contents $resolvedContent */
            $resolvedContent = match (true) {
                $this->pointsToVendorExtension($reference) => null,
                $this->isResolvedAsRcursiveReference($reference) => null,
                $reference->value()->isInternal() => $this->resolveInternalPointer($reference->value()->pointer()),
                default => $this->retrieveReference($reference->value()),
            };

            if ($resolvedContent === null) {
                continue;
            }

            if ($this->willRecurse($resolvedContent, $reference)) {
                $this->depth++;
            }

            if ($this->stopRecursion()) {
                $pointer = $this->parentReference->pointer()->append(...$reference->pointer()->getPropertyPaths());
                $contents = $contents->replaceAt(
                    $reference->pointer(),
                    new Contents((object) [
                        '$ref' => '#' . $pointer->value(),
                    ])
                );

                $this->recursiveReferences[$reference->pointer()->value()] = $reference;

                continue;
            }

            if ($resolvedContent->isResolved() === false) {
                $this->parentReference = $reference;
                $resolvedContent = $this->resolve($resolvedContent);
            }

            $contents = $contents->replaceAt($reference->pointer(), $resolvedContent);
        }

        return $contents;
    }

    private function resolveInternalPointer(JsonPointer $pointer): ?Contents
    {
        /** @var Contents $contents */
        $contents = $this->cache[$pointer->value()] ??= $this->contents?->at($pointer);

        return $contents;
    }

    private function retrieveReference(JsonReference $jsonReference): ?Contents
    {
        /** @var ?Contents $contents */
        $contents = $this->cache[$jsonReference->path()] ??= $this->retriever?->retrieve($jsonReference->path());

        return $contents?->at($jsonReference->pointer());
    }

    private function willRecurse(Contents $contents, Reference $reference): bool
    {
        if ($contents->isResolved()) {
            return false;
        }

        return $contents->containsJsonReference($reference->value());
    }

    private function pointsToVendorExtension(Reference $reference): bool
    {
        return str_contains($reference->pointer()->value(), 'x-');
    }

    private function isResolvedAsRcursiveReference(Reference $reference): bool
    {
        return array_key_exists($reference->pointer()->value(), $this->recursiveReferences)
            && $reference->value()->isInternal();
    }

    private function stopRecursion(): bool
    {
        $shouldStop = $this->depth > 1;

        if ($shouldStop) {
            $this->depth = 0;
        }

        return $shouldStop;
    }
}
