<?php
namespace MiniSkirt\ParsleyLite;

function app()
{
    return \App\State::getInstance();
}

function project_path()
{
    return dirname(__DIR__);
}

function response($content = '', $contentType = 'text/html', $status = 200)
{
    $resp = new \Slim\Psr7\Response;
    $resp = $resp->withStatus($status)
        ->withHeader('Content-Type', $contentType);
    $body = $resp->getBody();
    $body->write($content);

    return $resp;
}

function responsePlainText($content = '', $contentType = 'text/plain', $status = 200, $toStringHandler = null)
{
    if (! is_string($content)) {
        if ($toStringHandler) {
            $content = $toStringHandler($content);
        } else {
            $content = (string) $content;
        }
    }

    return response($content, $contentType, $status);
}

function responseJson($content = '', $contentType = 'text/json', $status = 200, $encodeHandler = null)
{
    $content = ($encodeHandler) ? $encodeHandler($content) : json_encode($content);

    return response($content, $contentType, $status);
}