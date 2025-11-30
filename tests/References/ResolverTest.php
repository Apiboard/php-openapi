<?php

use Apiboard\OpenAPI\Contents\Contents;
use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Retriever;
use Apiboard\OpenAPI\References\Resolver;

test('it can resolve basic external references', function () {
    $contents = new Json('{ "something": { "$ref": "ref-1.json" }, "simple": "value" }');
    $resolver = new Resolver(retriever(function () {
        return new Contents('{ "resolved": "the contents!" }');
    }));

    $result = $resolver->resolve($contents);

    expect($result->toArray())->toBe([
        'something' => [
            'resolved' => 'the contents!',
        ],
        'simple' => 'value',
    ]);
});

test('it can resolve external references with json pointers', function () {
    $contents = new Json('{ "something": { "$ref": "ref-1.json#/resolved/pointer" }, "simple": "value" }');
    $resolver = new Resolver(retriever(function () {
        return new Contents('{ "resolved": { "pointer": "the contents!" } }');
    }));

    $result = $resolver->resolve($contents);

    expect($result->toArray())->toBe([
        'something' => 'the contents!',
        'simple' => 'value',
    ]);
});

test('it can resolve external nested references', function () {
    $contents = new Json('{ "something": { "$ref": "ref-1.json" }, "simple": "value" }');
    $resolver = new Resolver(retriever(function (string $filePath) {
        $contents = match ($filePath) {
            'ref-1.json' => '{"different": { "$ref": "ref-2.json" } }',
            'ref-2.json' => '{"resolved": "the contents!"}',
        };

        return new Contents($contents);
    }));

    $result = $resolver->resolve($contents);

    expect($result->toArray())->toBe([
        'something' => [
            'different' => [
                'resolved' => 'the contents!',
            ],
        ],
        'simple' => 'value',
    ]);
});

test('it can resolve recursive external references', function () {
    $contents = new Json('{
        "something": {
            "$ref": "ref-1.json"
        },
        "other": {
            "$ref": "ref-1.json"
        },
        "simple": "value"
    }');
    $resolver = new Resolver(retriever(function (string $filePath) {
        $contents = match ($filePath) {
            'ref-1.json' => '{"different": { "$ref": "ref-1.json" } }',
        };

        return new Contents($contents);
    }));

    $result = $resolver->resolve($contents);

    expect($result->toArray())->toBe([
        'something' => [
            'different' => [
                '$ref' => '#/something/different',
            ],
        ],
        'other' => [
            'different' => [
                '$ref' => '#/other/different',
            ],
        ],
        'simple' => 'value',
    ]);
})->skip();

test('it retrieves duplicate external references only once', function () {
    $count = 0;
    $contents = new Json('{ "something": { "$ref": "ref-1.json" }, "same": { "$ref": "ref-1.json" } }');
    $resolver = new Resolver(retriever(function () use (&$count) {
        $count++;

        return new Contents('');
    }));

    $resolver->resolve($contents);

    expect($count)->toBe(1);
});

test('it retrieves duplicate external references with different json pointers only once', function () {
    $count = 0;
    $contents = new Json('{ "something": { "$ref": "ref-1.json#/some/pointer" }, "same": { "$ref": "ref-1.json#/some/different/pointer" } }');
    $resolver = new Resolver(retriever(function () use (&$count) {
        $count++;

        return new Contents('{
            "some": {
                "pointer": "The pointer value!",
                "different": {
                    "pointer": "The other pointer value!"
                }
            }
        }');
    }));

    $resolver->resolve($contents);

    expect($count)->toBe(1);
});

test('it does not resolve external references without a retriever', function () {
    $resolver = new Resolver();
    $contents = new Json('{ "something": { "$ref": "ref-1.json" } }');

    $result = $resolver->resolve($contents);

    expect($result)->toBe($contents);
});

test('it can resolve internal references', function () {
    $contents = new Json('{"something":{"$ref":"#/internal/thing"}, "internal": {"thing": "the internal result!"}}');
    $resolver = new Resolver();

    $result = $resolver->resolve($contents);

    expect($result->toArray())->toBe([
        'something' => 'the internal result!',
        'internal' => [
            'thing' => 'the internal result!',
        ],
    ]);
});

test('it can resolve empty contents correctly', function () {
    $contents = new Json('{}');
    $resolver = new Resolver();

    $result = $resolver->resolve($contents);

    expect($result->toObject())->toBeObject();
});

test('it ignores resolving references for vendor extensions', function () {
    $contents = new Json('{"x-topics": {"content": {"$ref": "./docs/getting-started.md"}}}');
    $resolved = false;
    $resolver = new Resolver(retriever(function () use (&$resolved) {
        $resolved = true;
        return new Contents('');
    }));

    $resolver->resolve($contents);

    expect($resolved)->toBeFalse();
});

function retriever(callable $callback): Retriever
{
    /** @var Retriever */
    $retriever = new class ($callback) implements Retriever {
        private Closure $callback;

        private string $basePath = '';

        public function __construct(Closure $callback)
        {
            $this->callback = $callback;
        }

        public function basePath(): string
        {
            return $this->basePath;
        }

        public function from(string $basePath): self
        {
            $this->basePath = $basePath;

            return $this;
        }

        public function retrieve(string $filePath): Contents
        {
            $callback = $this->callback;

            return $callback($filePath);
        }
    };

    return $retriever;
}
