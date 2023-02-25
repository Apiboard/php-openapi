# PHP OpenAPI

OpenAPI Specification parser for PHP 8. Supports both OAS 3.0 and 3.1.

[![Latest Version on Packagist](https://img.shields.io/packagist/vpre/apiboard/php-openapi.svg?style=flat-square)](https://packagist.org/packages/apiboard/php-openapi)
![PHP from Packagist](https://img.shields.io/packagist/php-v/apiboard/php-openapi?style=flat-square)
![CI](https://github.com/apiboard/php-openapi/workflows/CI/badge.svg?style=flat-square)

## Features

- Parse OpenAPI files into a PHP object to interact with in code
- Validate OpenAPI files against the official JSON-schema descriptions
- Resolve external references

## Installation

```bash
composer require apiboard/php-openapi
```

## Usage

You can interact with this library through the `OpenAPI::class` directly.

```php
$openAPI = new OpenAPI();
```
This class optionally accepts an implementation of `Apiboard\OpenAPI\Contents\Retriever::class` which will be used to retrieve the file contents. By default the local filesystem will be used to retrieve file contents.

### Parse

You can parse the contents of a file by passing its path to `parse()`. This will attempt to retrieve the file's contents and resolve any external references.

It returns a PHP object that represents the OAS document structure that can be used in code.
```php
$document = $openAPI->parse('/path/to/my-oas.json');

$document->openapi(); // 3.1.0
```

### Validate
You can directly validate the contents of a file against the official OpenAPI JSON-schema descriptions. It returns an array of possible errors that occured during the validation.

```php
$errors = $openAPI->validate('/path/to/my-oas.yaml');
```

> ⚠️ Validation for OAS 3.1 does not check any JSON Schemas in your OpenAPI document because it allows you to use any JSON Schema dialect you choose!

### Resolve

You can resolve external references. It returns a PHP object with the resolved contents.

```php
$contents = $openAPI->resolve('/path/to/my-oas.json');

$document = new Apiboard\OpenAPI\Structure\Document($contents);
```
When resolving external references the contents will be retrieved from the local fileystem by default. You can override the way file contents is retrieved by passing a custom class that implements the `Apiboard\OpenAPI\Contents\Retriever` interface.

```php

$customRetriever = new MyCustomRetriever();
$openAPI = new OpenAPI($customRetriever);

$openAPI->resolve('/path/to/my-oas.json');
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
