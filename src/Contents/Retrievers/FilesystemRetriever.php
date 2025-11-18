<?php

namespace Apiboard\OpenAPI\Contents\Retrievers;

use Apiboard\OpenAPI\Contents\Contents;
use Apiboard\OpenAPI\Contents\Retriever;

final class FilesystemRetriever implements Retriever
{
    private LocalFilesystemRetriever $local;

    private RemoteFilesystemRetriever $remote;

    public function __construct()
    {
        $this->local = new LocalFilesystemRetriever();
        $this->remote = new RemoteFilesystemRetriever();
    }

    public function from(string $baseUrl): Retriever
    {
        $this->try(fn () => $this->local->from($baseUrl));
        $this->try(fn () => $this->remote->from($baseUrl));

        return $this;
    }

    public function retrieve(string $filePath): Contents
    {
        if (filter_var($filePath, FILTER_VALIDATE_URL)) {
            return $this->remote->retrieve($filePath);
        }

        return $this->local->retrieve($filePath);
    }

    private function try(\Closure $callback, ?\Closure $fallback = null): mixed
    {
        try {
            return $callback();
        } catch (\Exception) {
            if ($fallback) {
                $fallback();
            }
        }

        return null;
    }
}
