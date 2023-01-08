<?php

namespace Apiboard\OpenAPI\Contents;

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Yaml;

interface Retriever
{
    public function from(string $basePath): Retriever;

    public function retrieve(string $filePath): Json|Yaml;
}
