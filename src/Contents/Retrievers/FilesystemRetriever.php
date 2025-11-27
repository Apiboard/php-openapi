<?php

namespace Apiboard\OpenAPI\Contents\Retrievers;

use Apiboard\OpenAPI\Contents\Contents;
use Apiboard\OpenAPI\Contents\Retriever;

final class FilesystemRetriever implements Retriever
{
    private ?Retriever $retriever = null;

    public function from(string $baseUrl): Retriever
    {
        $this->setRetrieverFromPath($baseUrl);

        $this->retriever->from($baseUrl);

        return $this;
    }

    public function retrieve(string $filePath): Contents
    {
        $this->setRetrieverFromPath($filePath);

        return $this->retriever->retrieve($filePath);
    }

    private function setRetrieverFromPath(string $path): void
    {
        if ($this->retriever === null) {
            $isUrl = (bool) filter_var($path, FILTER_VALIDATE_URL);

            if ($isUrl === true) {
                $this->retriever = new RemoteFilesystemRetriever();
            }

            if ($isUrl === false) {
                $this->retriever = new LocalFilesystemRetriever();
            }
        }
    }
}
