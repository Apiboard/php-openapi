<?php

namespace Apiboard\OpenAPI\Contents\Retrievers;

use Apiboard\OpenAPI\Contents\Contents;
use Apiboard\OpenAPI\Contents\Retriever;
use Symfony\Component\Filesystem\Path;

final class RemoteFilesystemRetriever implements Retriever
{
    private array $url;

    private ?string $from = null;

    public function __construct(string $baseUrl)
    {
        $this->url = parse_url($baseUrl);
    }

    public function from(string $url): Retriever
    {
        $this->from = $url;

        return $this;
    }

    public function retrieve(string $url): Contents
    {
        $validUrl = filter_var($url, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE);

        if ($validUrl === null) {
            $path = Path::canonicalize(dirname($this->url['path']) . ltrim($url, '.'));
            $validUrl = $this->url['scheme'].'://'.$this->url['host'].$path;
        }

        return new Contents(file_get_contents($validUrl));
    }
}
