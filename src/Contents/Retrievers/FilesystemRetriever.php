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

    private function setRetrieverFromPath(string $pathOrUrl): void
    {
        if ($this->retriever === null) {
            $isUrl = (bool) filter_var($pathOrUrl, FILTER_VALIDATE_URL);

            if ($isUrl === true) {
                $this->retriever = new RemoteFilesystemRetriever($pathOrUrl);
            }

            if ($isUrl === false) {
                $this->retriever = new LocalFilesystemRetriever();
            }
        }
    }
}
