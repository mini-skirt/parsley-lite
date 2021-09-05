<?php
namespace MiniSkirt\ParsleyLite;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

app()->get('/about', function ($req, $resp, $args) {
    return $this->get('view')->render($resp, 'about.twig');
});