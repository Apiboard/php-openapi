<?php

namespace Apiboard\OpenAPI;

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Yaml;

interface ReferenceResolver
{
    public function resolve(Json|Yaml $contents): Json|Yaml;
}
