<?php

namespace Apiboard\OpenAPI\References;

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Yaml;

interface Retriever
{
    public function retrieve(string $filePath): Json|Yaml;
}
