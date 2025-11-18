<?php

use Apiboard\OpenAPI\Finders\Endpoint;
use Apiboard\OpenAPI\Finders\EndpointFinder;
use Apiboard\OpenAPI\Structure\Document;

function requestFactory(): \Psr\Http\Message\RequestFactoryInterface
{
    return new \Nyholm\Psr7\Factory\Psr17Factory();
}

function endpointFinder(Document $document): EndpointFinder
{
    return new EndpointFinder($document);
}

function assertFoundPathAndOperation(?Endpoint $result, string $method, string $path): void
{
    expect($result)->not->toBeNull();
    expect($result->operation()->method())->toBe($method);
    expect($result->pathItem()->uri())->toBe($path);
}

it('can find the endpoint from a request that matches', function () {
    $request = requestFactory()->createRequest('GET', 'https://example.com/quotes/short');

    $document = jsonDocument('{
        "paths" : {
            "/quotes/{format}": {"get": {}}
        }
    }');

    $result = endpointFinder($document)->findByPsrRequest($request);

    assertFoundPathAndOperation($result, 'get', '/quotes/{format}');
});

it('can find the endpoint from a request that matches with a server path', function () {
    $request = requestFactory()->createRequest('GET', '/api/v2/example');
    $document = jsonDocument('{
        "servers": [
            {"url": "/api/{version}"}
        ],
        "paths" : {
            "/example": {"get": {}}
        }
    }');

    $result = endpointFinder($document)->findByPsrRequest($request);

    assertFoundPathAndOperation($result, 'get', '/example');
});

it('can find the endpoint from a request that matches with a server url', function () {
    $request = requestFactory()->createRequest('GET', 'https://example.com/api/example');
    $document = jsonDocument('{
        "servers": [
            {"url": "https://example.com/api"}
        ],
        "paths" : {
            "/example": {"get": {}}
        }
    }');

    $result = endpointFinder($document)->findByPsrRequest($request);

    assertFoundPathAndOperation($result, 'get', '/example');
});

it('returns null when there is no matching path for the request', function () {
    $request = requestFactory()->createRequest('GET', '/example');
    $document = jsonDocument('{
        "paths" : {
            "/other-example": {"get": {}}
        }
    }');

    $result = endpointFinder($document)->findByPsrRequest($request);

    expect($result)->toBeNull();
});

it('returns null when there is no matching method for the request', function () {
    $request = requestFactory()->createRequest('POST', '/example');
    $document = jsonDocument('{
        "paths" : {
            "/example": {"get": {}}
        }
    }');

    $result = endpointFinder($document)->findByPsrRequest($request);

    expect($result)->toBeNull();
});

it('ignores the server host when finding the endpoint', function () {
    $request = requestFactory()->createRequest('GET', 'https://example.com/example');
    $document = jsonDocument('{
        "servers": [
            {"url": "https://other-example.com"}
        ],
        "paths" : {
            "/example": {"get": {}}
        }
    }');

    $result = endpointFinder($document)->findByPsrRequest($request);

    assertFoundPathAndOperation($result, 'get', '/example');
});

it('prioritizes matches with more static paths first', function () {
    $request = requestFactory()->createRequest('GET', '/quotes/authors/@me');
    $document = jsonDocument('{
        "paths" : {
            "/quotes/{format}/{author}": {"get": {}},
            "/quotes/authors/{author}": {"get": {}}
        }
    }');

    $result = endpointFinder($document)->findByPsrRequest($request);

    assertFoundPathAndOperation($result, 'get', '/quotes/authors/{author}');
});

it('prioritizes paths with equal amount of parameters where the request path has an exact parameter value first', function () {
    $requestA = requestFactory()->createRequest('GET', '/products/1/images/thumbnails/primary');
    $requestB = requestFactory()->createRequest('GET', '/products/1/images/banners/primary');
    $document = jsonDocument('{
        "paths" : {
            "/products/{product}/images/{type}/{size}": {"get": {}},
            "/products/{product}/images/thumbnails/{size}": {"get": {}},
            "/products/{product}/images/{type}/primary": {"get": {}}
        }
    }');
    $finder = endpointFinder($document);

    $resultA = $finder->findByPsrRequest($requestA);
    $resultB = $finder->findByPsrRequest($requestB);

    assertFoundPathAndOperation($resultA, 'get', '/products/{product}/images/thumbnails/{size}');
    assertFoundPathAndOperation($resultB, 'get', '/products/{product}/images/{type}/primary');
});

it('can find endpoints by operation id', function () {
    $document = jsonDocument('{
        "paths" : {
            "/products/{product}/images/{type}/{size}": {"get": {
                "operationId": "get-product-image-by-type-and-size"
            }},
            "/products/{product}/images/thumbnails/{size}": {"get": {
                "operationId": "get-product-thumbnail-size"
            }},
            "/products/{product}/images/{type}/primary": {"get": {
                "operationId": "get-product-primary-size"
            }}
        }
    }');
    $finder = endpointFinder($document);

    $resultA = $finder->findByOperationId('get-product-thumbnail-size');
    $resultB = $finder->findByOperationId('get-product-primary-size');

    assertFoundPathAndOperation($resultA, 'get', '/products/{product}/images/thumbnails/{size}');
    assertFoundPathAndOperation($resultB, 'get', '/products/{product}/images/{type}/primary');
});
