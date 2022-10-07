<?php

namespace Apiboard\OpenAPI\Concerns;

use Apiboard\OpenAPI\Structure\Schema;

trait HasASchema
{
    public function schema(): Schema
    {
        return new Schema($this->data['schema']);
    }
}
