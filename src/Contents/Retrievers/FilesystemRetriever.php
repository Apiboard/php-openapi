<?php

namespace Apiboard\OpenAPI\Contents\Retrievers;

use Apiboard\OpenAPI\Contents\Contents;
use Apiboard\OpenAPI\Contents\Retriever;

final class FilesystemRetriever implements Retriever
{
    private ?Retriever $retriever = null;

    public function from(string $baseUrl): Retriever
    {
        if ($this->retriever) {
            $this->retriever->from($baseUrl);

            return $this;
        }

        $isUrl = filter_var($baseUrl, FILTER_VALIDATE_URL);

        if ($isUrl === true) {
            $this->retriever = new RemoteFilesystemRetriever();
        }

        if ($isUrl === false) {
            $this->retriever = new LocalFilesystemRetriever();
        }

        return $this;
    }

    public function retrieve(string $filePath): Contents
    {
        return $this->retriever->retrieve($filePath);
    }

}
