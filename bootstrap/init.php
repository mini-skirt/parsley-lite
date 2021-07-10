<?php
require __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\State as AppState;

function app()
{
    return AppState::getInstance();
}

function project_path()
{
    return dirname(__DIR__);
}

$config = require project_path().'/config.php';

if (is_file(project_path().'/config.secret.php')) {
    $config_secret = require project_path().'/config.secret.php';
} else {
    $config_secret = [];
}

if ($config === 1 or $config === false) $config = [];
if ($config_secret === 1 or $config === false) $config_secret = [];

$container = new Container;

AppFactory::setContainer($container);

$container->set('view', function() use ($config) {
    return Twig::create(
        $config['dependency']['twig']['view'], 
        ['cache' => $config['dependency']['twig']['cache']]
    );
});

AppState::setInstance(AppFactory::create());

app()->add(TwigMiddleware::createFromContainer(app()));

require 'route.php';

app()->run();