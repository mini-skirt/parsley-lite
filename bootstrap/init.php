<?php
namespace MiniSkirt\ParsleyLite;

/*
Parsley Lite Project

mini-skirt@outlook.com
github.com/mini-skirt



# File life-time load sequence
/public/index.php -> /bootstrap/init.php {
    req /vendor/autoload.php
    req /config.php
    req /config.secret.php
    req /route.php
}

# Code content description
A. Load dependecies and autoloader
B. Define base functions
C. Load and init configs
D. Setup container and dependencies

*/



// #A  Load dependencies and autoloader
require __DIR__ . '/../vendor/autoload.php';

// #B  Load base functions
require 'fn.php';


// #C  Load and init configs
$config = require project_path().'/config.php';

if (is_file(project_path().'/config.secret.php')) {
    $config_secret = require project_path().'/config.secret.php';
} else {
    $config_secret = [];
}

if ($config === 1 or $config === false) $config = [];
if ($config_secret === 1 or $config === false) $config_secret = [];



// #D  Setup container and dependencies
$container = new \DI\Container;

$container->set('view', function ($container) use ($config) {
    return \Slim\Views\Twig::create(
        $config['dependency']['twig']['view'], 
        ['cache' => $config['dependency']['twig']['cache']]
    );
});

\Slim\Factory\AppFactory::setContainer($container);

\App\State::setInstance(\Slim\Factory\AppFactory::create());

app()->add(\Slim\Views\TwigMiddleware::createFromContainer(app()));

require 'route.php';

app()->run();
