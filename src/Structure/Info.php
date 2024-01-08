<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeDescribed;
use Apiboard\OpenAPI\Concerns\HasVendorExtensions;
use Apiboard\OpenAPI\References\JsonPointer;

final class Info extends Structure
{
    use CanBeDescribed;
    use HasVendorExtensions;

    public function title(): string
    {
        return $this->data['title'];
    }

    public function version(): string
    {
        return $this->data['version'];
    }

    public function termsOfService(): ?string
    {
        return $this->data['termsOfService'] ?? null;
    }

    public function license(): ?License
    {
        $license = $this->data['license'] ?? null;

        if ($license === null) {
            return null;
        }

        return new License($license);
    }

    public function contact(): ?Contact
    {
        $contact = $this->data['contact'] ?? null;

        if ($contact === null) {
            return null;
        }

        return new Contact($contact);
    }

    public function pointer(): ?JsonPointer
    {
        return new JsonPointer('#/info');
    }
}
