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
        return $this->try(
            fn () => $this->local->retrieve($filePath),
            fn () => $this->remote->retrieve($filePath),
        );
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
