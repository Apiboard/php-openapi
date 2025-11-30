<?php

namespace Apiboard\OpenAPI\Contents\Retrievers;

use Apiboard\OpenAPI\Contents\Contents;
use Apiboard\OpenAPI\Contents\Retriever;
use Symfony\Component\Filesystem\Path;

final class RemoteFilesystemRetriever implements Retriever
{
    private array $url;

    public function __construct(string $baseUrl)
    {
        $this->url = parse_url($baseUrl);
        $info = pathinfo($this->url['path']);
        if ($info['extension'] ?? false) {
            $this->url['path'] = $info['dirname'];
        }
    }

    public function from(string $url): Retriever
    {
        $validUrl = filter_var($url, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE);

        if ($validUrl === null) {
            $validUrl = $this->canonicalizedUrl($url);
        }

        return new self($url);
    }

    public function retrieve(string $url): Contents
    {
        $validUrl = filter_var($url, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE);

        if ($validUrl === null) {
            $validUrl = $this->canonicalizedUrl($url);
        }

        return new Contents(file_get_contents($validUrl));
    }

    private function canonicalizedUrl(string $path): string
    {
        $path = Path::canonicalize($this->url['path'].ltrim($path, '.'));

        return $this->url['scheme'].'://'.$this->url['host'].$path;
    }
}
