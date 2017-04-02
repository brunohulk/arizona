<?php

// configure your app for the production environment

$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

$app['host_country_data'] = "http://www.umass.edu/microbio/rasmol/country-.txt";
$app['db_name'] = 'arizona';