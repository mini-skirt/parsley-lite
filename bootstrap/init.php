<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\State as AppState;
use DI\Container;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

function app()
{
    return AppState::getInstance();
}

function project_path()
{
    return dirname(__DIR__);
}
$config = require project_path().'/config.php';
$container = new Container;
AppFactory::setContainer($container);

$container->set('view', function() use ($config) {
    return Twig::create($config['dependency']['twig']['view'], ['cache' => $config['dependency']['twig']['cache']]);
});

AppState::setInstance(AppFactory::create());

app()->add(TwigMiddleware::createFromContainer(app()));

require 'route.php';

app()->run();