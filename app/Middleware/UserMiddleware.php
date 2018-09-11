<?php
namespace App\Middleware;

use App\Helpers\Authentication\Auth;

use Slim\Router;
use Slim\Views\Twig;
use Slim\Flash\Messages;

class UserMiddleware
{
    protected $view, $auth;

    public function __construct(Twig $view, Auth $auth)
    {
        $this->view = $view;
        $this->auth = $auth;
    }

    public function __invoke($request, $response, $next)
    {
        $this->view->getEnvironment()->addGlobal('auth', [
            'check' => $this->auth->check(),
            'user'  => $this->auth->user()
        ]);

        $response = $next($request, $response);
        return $response;
    }
}
