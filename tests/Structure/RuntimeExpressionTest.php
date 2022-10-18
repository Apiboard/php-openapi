<?php

use Apiboard\OpenAPI\Structure\RuntimeExpression;

test('it can return the expression value', function () {
    $runtimeExpresssion = new RuntimeExpression('', '$url');

    $result = $runtimeExpresssion->value();

    expect($result)->toBe('$url');
});

test('it can return the expression key', function () {
    $runtimeExpresssion = new RuntimeExpression('key', '$url');

    $result = $runtimeExpresssion->key();

    expect($result)->toBe('key');
});
