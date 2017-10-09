<?php

namespace Webbower\Middleware;

class CharsetMiddleware extends \Slim\Middleware
{
    public function call()
    {
      $this->next->call();

      $res = $this->app->response;
      $contentType = $res->headers->get('Content-Type');
      if (strpos($contentType, 'charset') === false) {
        $res->headers->set('Content-Type', "{$contentType}; charset=utf-8");
      }
    }
}