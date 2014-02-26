<?php
/**
 * User: frank
 * Date: 15/02/14
 * Time: 11:24
 */

$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'elasticsearch.host' => '127.0.0.1',
        'elasticsearch.port' => 9200,
        'elasticsearch.index' => 'zando',
    ));
});

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'elasticsearch.host' => '127.0.0.1',
        'elasticsearch.port' => 9200,
        'elasticsearch.index' => 'zando',
        'log.enabled' => true,
        'debug' => true,
    ));
});