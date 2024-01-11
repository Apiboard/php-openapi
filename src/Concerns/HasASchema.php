<?php

namespace Apiboard\OpenAPI\Concerns;

use Apiboard\OpenAPI\References\JsonReference;
use Apiboard\OpenAPI\Structure\Schema;

trait HasASchema
{
    use HasReferences;

    public function schema(): Schema|JsonReference
    {
        $schema = $this->data['schema'];

        if ($this->isReference($schema)) {
            return new JsonReference($schema['$ref']);
        }

        return new Schema($schema, $this->pointer?->append('schema'));
    }
}
