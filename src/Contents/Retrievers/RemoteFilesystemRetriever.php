<?php

namespace Apiboard\OpenAPI\Contents\Retrievers;

use Apiboard\OpenAPI\Contents\Contents;
use Apiboard\OpenAPI\Contents\Retriever;
use Symfony\Component\Filesystem\Path;

final class RemoteFilesystemRetriever implements Retriever
{
    private ?string $baseUrl = null;

    public function from(string $baseUrl): Retriever
    {
        $parts = parse_url($baseUrl);
        $path = explode('/', $parts['path']);
        array_pop($path);

        $this->baseUrl = $parts['scheme'] . '://' . $parts['host']  . rtrim(implode('/', $path), '/') . '/';

        return $this;
    }

    public function retrieve(string $url): Contents
    {
        $validUrl = filter_var($url, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE);

        if ($validUrl === null && $this->baseUrl) {
            $baseParts = parse_url($this->baseUrl);
            $path = Path::canonicalize($baseParts['path'] . $url);
            $url = $baseParts['scheme'] . '://' . $baseParts['host'] . $path;
        }

        return new Contents(file_get_contents($url));
    }
}
