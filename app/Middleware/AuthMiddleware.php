<?php
namespace App\Middleware;

use Slim\Router;
use Slim\Flash\Messages;

class AuthMiddleware
{
    protected $message, $router;

    public function __construct(Messages $message, Router $router)
    {
        $this->message = $message;
        $this->router = $router;
    }

    public function __invoke($request, $response, $next)
    {
        if (!isset($_COOKIE['user'])) {
            $this->message->addMessage('success', 'Please sign in before doing that!');
            return $response->withRedirect($this->router->pathFor('home'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
