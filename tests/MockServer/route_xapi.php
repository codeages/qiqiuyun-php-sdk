<?php
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

$xapi = $app['controllers_factory'];

$xapi->post('/statements', function(Application $app, Request $request) {
    return $app->json(array('success' => true));
});

$app->mount('/xapi', $xapi);