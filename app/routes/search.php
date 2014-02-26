<?php
/**
 * User: frank
 * Date: 15/02/14
 * Time: 11:18
 */

$app->get('/search/:query', function ($query) use ($app) {

    $elasticaClient = new Elastica\Client([
        'host'            => $app->config('elasticsearch.host'),
        'port'            => $app->config('elasticsearch.port')
    ]);

    $search = new Zando\Search($elasticaClient, $app->config('elasticsearch.index'));


    $searchResult = $search->search($query);

    foreach ($searchResult['myFacetName']['terms'] as $result) {
           var_dump($result);
    }

});