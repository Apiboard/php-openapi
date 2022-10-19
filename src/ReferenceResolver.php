<?php

namespace Apiboard\OpenAPI;

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Yaml;

final class ReferenceResolver
{
    private ?ReferenceRetriever $retriever;

    public function __construct(?ReferenceRetriever $retriever = null)
    {
        $this->retriever = $retriever;
    }

    public function resolve(Json|Yaml $contents): Json|Yaml
    {
        if ($this->retriever === null) {
            return $contents;
        }

        foreach ($contents->references() as $reference) {
            $this->retriever->retrieve($reference);
        }

        return $contents;
    }
}
