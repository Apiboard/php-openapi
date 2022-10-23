<?php

namespace Apiboard\OpenAPI\Concerns;

use Apiboard\OpenAPI\Contents\Reference;
use Apiboard\OpenAPI\Structure\Schema;

trait HasASchema
{
    use HasReferences;

    public function schema(): Schema|Reference
    {
        $schema = $this->data['schema'];

        if ($this->isReference($schema)) {
            return new Reference($schema['$ref']);
        }

        return new Schema($schema);
    }
}
