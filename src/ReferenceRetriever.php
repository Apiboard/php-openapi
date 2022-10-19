<?php

namespace Apiboard\OpenAPI;

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Reference;
use Apiboard\OpenAPI\Contents\Yaml;

interface ReferenceRetriever
{
    public function retrieve(Reference $reference): Json|Yaml;
}
