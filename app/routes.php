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
};
