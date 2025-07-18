<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use App\Controller\HygraphClient;

class HomeController
{
    private HygraphClient $client;

    public function __construct()
    {
        $this->client = new HygraphClient();
    }

    public function index(Request $request, Response $response): Response
    {
        $view = Twig::fromRequest($request);

        try {
            $settings = $this->client->getSettings();
            $slides = $this->client->getSlides();

            return $view->render($response, 'pages/home.twig', [
                'settings' => $settings,
                'slides' => $slides,
            ]);

        } catch (\Exception $e) {
            // Hata durumunda server error sayfasını göster
            return $view->render($response, 'pages/server-error.twig', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
