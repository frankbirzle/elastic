<?php
/**
 * User: frank
 * Date: 15/02/14
 * Time: 11:18
 */

$app->get('/import', function () {

    $importer = new \Zando\Import();
    $importer->import();

});