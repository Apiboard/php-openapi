<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;

final class Server extends Structure
{
    use CanBeDescribed;
    use HasVendorExtensions;

    public function url(): string
    {
        return $this->data['url'];
    }

    public function variables(): ?array
    {
        $variables = $this->data['variables'] ?? null;

        if ($variables === null) {
            return null;
        }

        return array_map(fn (array $value) => new ServerVariable($value), $variables);
    }
}
