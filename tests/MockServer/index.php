<?php

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

require_once __DIR__.'/../../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

require __DIR__.'/route_xapi.php';

$app->run();