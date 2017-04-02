<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Lalbert\Silex\Provider\MongoDBServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider(), ['twig.options' => array('debug' => true)]);
$app->register(new HttpFragmentServiceProvider());

$app->register(new MongoDBServiceProvider(), [
    'mongodb.config' => [
        'server' => 'mongodb://localhost:27017', #TODO mover para arquivo de configuração
        'options' => [],
        'driverOptions' => []
    ]
]);

$app['csv'] = function ($app) {
    return new Resources\Csv($app['csv_file']);
};

$app['repository.country'] = function ($app) {
    return new Repository\Country($app);
};

$app['model.country'] = function ($app) {
    return new Model\Country(
        new GuzzleHttp\Client(
            [ 'base_uri' => $app['host_country_data']]
        ),
        $app['repository.country']
    );
};

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    return $twig;
});

return $app;
