<?php

use Apiboard\OpenAPI\Contents\Json;
use Apiboard\OpenAPI\Contents\Retriever;
use Apiboard\OpenAPI\Contents\Yaml;
use Apiboard\OpenAPI\OpenAPI;
use Apiboard\OpenAPI\Structure\Document;
use PHPUnit\Framework\Assert;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeArrayOf', function (string $class) {
    /** @var array */
    $items = $this->value;

    foreach ($items as $value) {
        Assert::assertInstanceOf($class, $value);
    }
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function openAPI(?Retriever $retriever = null): OpenAPI
{
    return new OpenAPI($retriever);
}

function fixture(string $path): string
{
    return __DIR__."/__fixtures__/{$path}";
}

function tap(mixed $result, callable $callback)
{
    $callback($result);

    return $result;
}

function jsonDocument(string $json): Document
{
    $contents = new Json($json);

    return new Document($contents);
}

function yamlDocument(string $yaml): Document
{
    $contents = new Yaml($yaml);

    return new Document($contents);
}
