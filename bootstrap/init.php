<?php
/*

File seq

/public/index.php -> /bootstrap/init.php {
    req /vendor/autoload.php
    req /config.php
    req /config.secret.php
    req /route.php
}

*/

require __DIR__ . '/../vendor/autoload.php';


// Base functions
function app()
{
    return \App\AppState::getInstance();
}

function project_path()
{
    return dirname(__DIR__);
}



// Config
$config = require project_path().'/config.php';

if (is_file(project_path().'/config.secret.php')) {
    $config_secret = require project_path().'/config.secret.php';
} else {
    $config_secret = [];
}

if ($config === 1 or $config === false) $config = [];
if ($config_secret === 1 or $config === false) $config_secret = [];



// Dependency
$container = new \DI\Container;

\Slim\Factory\AppFactory::setContainer($container);

$container->set('view', function() use ($config) {
    return \Slim\Views\Twig::create(
        $config['dependency']['twig']['view'], 
        ['cache' => $config['dependency']['twig']['cache']]
    );
});

\App\AppState::setInstance(AppFactory::create());

app()->add(\Slim\Views\TwigMiddleware::createFromContainer(app()));

require 'route.php';

app()->run();
