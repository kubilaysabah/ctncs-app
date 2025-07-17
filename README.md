# CTNCS App

A modern PHP web application built with Slim Framework that integrates with Hygraph CMS for content management.

## Features

- **Slim Framework 4**: Lightweight and fast PHP micro-framework
- **Hygraph Integration**: GraphQL-based headless CMS integration
- **Twig Templating**: Clean and secure template engine
- **Environment Configuration**: Secure configuration management with dotenv
- **PSR Standards**: Follows PHP-FIG standards for modern PHP development

## Requirements

- PHP 8.0 or higher
- Composer
- Web server (Apache/Nginx) or PHP built-in server

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd ctncs-app
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment Configuration**
   
   Create a `.env` file in the root directory and configure your Hygraph settings:
   ```env
   HYGRAPH_API_URL=https://your-hygraph-endpoint.hygraph.com/v2/your-project-id/master
   HYGRAPH_API_KEY=your-api-key-here
   ```

## Usage

### Development Server

Start the development server using Composer:

```bash
composer start
```

The application will be available at `http://localhost:8080`

### Production Deployment

For production deployment, configure your web server to point to the `app` directory and ensure the `app/index.php` file is the entry point.

## Project Structure

```
├── app/
│   ├── index.php          # Application entry point
│   └── routes.php         # Route definitions
├── controller/
│   ├── HomeController.php # Main page controller
│   └── HygraphClient.php  # GraphQL client for Hygraph
├── templates/
│   ├── layouts/           # Base layouts
│   ├── pages/            # Page templates
│   └── partials/         # Reusable components
├── vendor/               # Composer dependencies
├── composer.json         # Project dependencies and scripts
└── .env                  # Environment configuration (create this)
```

## Development

### Adding New Routes

Edit `app/routes.php` to add new routes:

```php
$app->get('/new-route', [YourController::class, 'method'])->setName('route-name');
```

### Creating Controllers

Controllers should be placed in the `controller/` directory and use the `App\Controller` namespace:

```php
<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class YourController
{
    public function method(Request $request, Response $response): Response
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'template.twig', $data);
    }
}
```

### GraphQL Queries

Use the `HygraphClient` to execute GraphQL queries:

```php
$client = new HygraphClient();
$result = $client->query('
    query {
        // Your GraphQL query here
    }
');
```

## Available Scripts

- `composer start` - Start development server
- `composer dump` - Regenerate autoloader

## Dependencies

### Main Dependencies
- **slim/slim**: Micro-framework for PHP
- **slim/twig-view**: Twig integration for Slim
- **guzzlehttp/guzzle**: HTTP client library
- **webonyx/graphql-php**: GraphQL implementation
- **vlucas/phpdotenv**: Environment variable loader

## Error Handling

The application includes error handling templates:
- `templates/pages/server-error.twig` - For server errors
- `templates/pages/not-found.twig` - For 404 errors

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test your changes
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support and questions, please contact the development team.
