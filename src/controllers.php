
<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage');

$app->get('/html', function (Request $request) use ($app) {
    $countries = $app['model.country']->countriesListOrderByName($request->get('order'));

    return $app['twig']->render('render.html.twig', array('countries' => $countries));
})->bind('render');

$app->get('/csv', function (Request $request) use ($app) {
    $countries = $app['model.country']->countriesListOrderByName($request->get('order'));
    $file = $app['csv']->export($countries);

    return $app->sendFile($file, 200, array('Content-type' => 'text/csv'))->setContentDisposition(
        'attachment',
        'countries_list.csv'
    );
});

$app->error(function (\Exception $exception, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
