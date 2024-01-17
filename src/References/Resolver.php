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

    public function __construct(Retriever $retriever = null)
    {
        $this->retriever = $retriever;
    }

    public function resolve(Json|Yaml $contents): Json|Yaml
    {
        foreach ($contents->references() as $reference) {
            if ($reference->value()->isInternal()) {
                continue;
            }

            $resolvedContent = $this->retrieveReference($reference->value());

            if ($resolvedContent === null) {
                continue;
            }

            if ($this->willRecurse($resolvedContent, $reference)) {
                $this->depth++;
            }

            if ($this->stopRecursion()) {
                $contents = $contents->replaceAt(
                    $reference->pointer(),
                    new Contents((object) [
                        '$ref' => '#' . $reference->pointer()->value(),
                    ])
                );

                continue;
            }

            $contents = $this->resolve(
                $contents->replaceAt($reference->pointer(), $resolvedContent),
            );
        }

        return $contents;
    }

    private function retrieveReference(JsonReference $jsonReference): ?Contents
    {
        if ($this->retriever === null) {
            return null;
        }

        /** @var Contents $contents */
        $contents = $this->cache[$jsonReference->path()] ??= $this->retriever?->retrieve($jsonReference->path());

        return $contents->at($jsonReference->pointer());
    }

    private function willRecurse(Contents $contents, Reference $reference): bool
    {
        if ($contents->isResolved()) {
            return false;
        }

        return $contents->containsJsonReference($reference->value());
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
