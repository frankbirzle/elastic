<?php
/**
 * User: frank
 * Date: 13/02/14
 * Time: 22:57
 */

require_once '../app/vendor/autoload.php';

$app = new \Slim\Slim(
    ['mode' => 'production']
);

require_once '../app/config/app.php';
require_once '../app/routes/search.php';
require_once '../app/routes/import.php';
require_once '../app/routes/fetch.php';

$app->run();
