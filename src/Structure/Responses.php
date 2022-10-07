<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use ArrayAccess;
use Countable;

final class Responses implements ArrayAccess, Countable
{
    use AsCountableArray;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $statusCode=>$value) {
            $data[$statusCode] = new Response($statusCode, $value);
        }

        $this->data = $data;
    }

    public function offsetGet(mixed $statusCode): ?Response
    {
        return $this->data[$statusCode] ?? null;
    }
}
