<?php

namespace Apiboard\OpenAPI\References;

final class Reference
{
    private JsonReference $value;

    private ?JsonPointer $pointer;

    public function __construct(string $value, ?JsonPointer $pointer = null)
    {
        $this->value = new JsonReference($value);
        $this->pointer = $pointer;
    }

    public function pointer(): ?JsonPointer
    {
        return $this->pointer;
    }

    public function value(): JsonReference
    {
        return $this->value;
    }

    public function equals(Reference $reference): bool
    {
        return $this->value->value() === $reference->value()->value();
    }
}
