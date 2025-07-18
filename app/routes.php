<?php

use App\Controller\HomeController;
use Slim\App;

return function (App $app) {
    // Home route
    $app->get('/', [HomeController::class, 'index'])->setName('home');

    // Favicon.ico route to prevent 404 errors
    $app->get('/favicon.ico', function ($request, $response) {
        return $response->withStatus(204);
    });

    // Chrome DevTools ve diğer browser otomatik istekleri için
    $app->get('/.well-known/{path:.*}', function ($request, $response) {
        return $response->withStatus(204);
    });

    // Robots.txt için
    $app->get('/robots.txt', function ($request, $response) {
        return $response->withStatus(204);
    });

    // Apple touch icon için
    $app->get('/apple-touch-icon{suffix:.*}.png', function ($request, $response) {
        return $response->withStatus(204);
    });
};
