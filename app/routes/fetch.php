<?php
/**
 * User: frank
 * Date: 15/02/14
 * Time: 11:18
 */

$app->get('/fetch/:id', function ($id = 'zandoproduct_92553AC86FKV') {

    $cb = new Couchbase("127.0.0.1:8091", "default", "", "default");
    $result = $cb->get($id);

    echo "<pre>";
    var_dump(json_decode($result));
    echo "</pre>";
});