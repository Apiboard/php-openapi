<?php

namespace Apiboard\OpenAPI\Contents;

interface Retriever
{
    public function basePath(): string;

    public function from(string $basePath): Retriever;

    public function retrieve(string $filePath): Json|Yaml;
}
