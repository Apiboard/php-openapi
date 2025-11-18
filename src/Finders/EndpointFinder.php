<?php

namespace Apiboard\OpenAPI\Finders;

use Apiboard\OpenAPI\Structure\Document;
use Apiboard\OpenAPI\Structure\PathItem;
use Apiboard\OpenAPI\Structure\Server;
use Psr\Http\Message\UriInterface;

final class EndpointFinder
{
    private Document $document;

    private const PATH_PLACEHOLDER = '#{[^}]+}#';

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function findByPsrRequest(\Psr\Http\Message\RequestInterface $request): ?Endpoint
    {
        $method = strtolower($request->getMethod());

        // Try a direct match in case there's no variables in the path.
        $pathItem = $this->document->paths()->offsetGet($request->getUri()->getPath());
        if ($pathItem && $this->matches($pathItem, $request->getUri())) {
            return $this->mapToEndpoint($pathItem, $method);
        }

        $matches = [];

        foreach ($this->document->paths() as $pathItem) {
            if ($this->matches($pathItem, $request->getUri())) {
                array_push($matches, $pathItem);
            }
        }

        return $this->mapToEndpoint(
            $this->chooseMostStaticMatch($matches, $request->getUri()),
            $method,
        );
    }

    public function findByOperationId(string $id): ?Endpoint
    {
        foreach ($this->document->paths() as $pathItem) {
            foreach ($pathItem->operations() as $operation) {
                if ($operation->operationId() === $id) {
                    return new Endpoint($pathItem, $operation);
                }
            }
        }

        return null;
    }

    private function matches(PathItem $pathItem, \Psr\Http\Message\UriInterface $uri): bool
    {
        $servers = $pathItem->servers() ?? $this->document->servers();

        if ($servers === null) {
            return $this->matchedByPath($pathItem->uri(), $uri->getPath());
        }

        foreach ($servers as $server) {
            if ($this->matchedByPathAndServer($pathItem, $server, $uri)) {
                return true;
            }
        }

        return false;
    }

    private function matchedByPath(string $specPath, string $path): bool
    {
        if ($specPath === $path) {
            return true;
        }

        $pattern = '#' . preg_replace(self::PATH_PLACEHOLDER, '[^/]+', $specPath) . '/?$#';

        return (bool) preg_match($pattern, $path);
    }

    private function matchedByPathAndServer(PathItem $pathItem, Server $server, UriInterface $uri): bool
    {
        $serverPath = (string) parse_url($server->url(), PHP_URL_PATH);

        $specPath = rtrim($serverPath, '/') . $pathItem->uri();

        return $this->matchedByPath($specPath, $uri->getPath());
    }

    /**
     * @param array<int,PathItem> $paths
     */
    private function chooseMostStaticMatch(array $paths, UriInterface $uri): ?PathItem
    {
        if (count($paths) === 0) {
            return null;
        }

        if (count($paths) === 1) {
            return $paths[0];
        }

        // Sort paths by least amount of dynamic parameters
        usort($paths, function (PathItem $a, PathItem $b) {
            $countA = $this->countParameters($a->uri());
            $countB = $this->countParameters($b->uri());

            return $countA <=> $countB;
        });

        // Sort paths by best static matching parameter first
        usort($paths, function (PathItem $a, PathItem $b) use ($uri) {
            $countA = $this->countMatchedParameters($a->uri(), $uri->getPath());
            $countB = $this->countMatchedParameters($b->uri(), $uri->getPath());

            return $countB <=> $countA;
        });

        return $paths[0];
    }

    private function countParameters(string $path): int
    {
        return (int) preg_match_all(self::PATH_PLACEHOLDER, $path);
    }

    private function countMatchedParameters(string $comparison, string $path): int
    {
        $comparisonParameters = explode('/', trim($comparison, '/'));
        $pathParameters = explode('/', trim($path, '/'));
        $matched = 0;

        foreach ($pathParameters as $index => $parameter) {
            if ($parameter === $comparisonParameters[$index]) {
                $matched++;
            }
        }

        return $matched;
    }

    private function mapToEndpoint(?PathItem $pathItem, string $method): ?Endpoint
    {
        if ($pathItem === null) {
            return null;
        }

        $operation = $pathItem->operations()->offsetGet($method);

        if ($operation) {
            return new Endpoint($pathItem, $operation);
        }

        return null;
    }
}
