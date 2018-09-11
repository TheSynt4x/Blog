<?php
namespace App\Controllers;

use App\Helpers\Authentication\Auth;
use App\Helpers\Validation\Validator;
use App\Helpers\Pagination\Paginate as Pagination;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Respect\Validation\Validator as v;

use Slim\Router;
use Slim\Views\Twig;
use Slim\Flash\Messages;

use App\Models\User;


/**
 * Authentication Controller
 */
class AuthController
{
    /**
     * Retrieves the login template
     * @param  Request  $request  Page request
     * @param  Response $response Page response
     * @param  Twig     $view     Twig view
     * @return Twig               Page template
     */
    public function getSignIn(Request $request, Response $response, Twig $view)
    {
        return $view->render($response, 'auth/signin.twig');
    }

    /**
     * User login
     * @param  Request   $request    Page Request
     * @param  Response  $response   Page Response
     * @param  Router    $router     Slim Router
     * @param  Messages  $message    Flash Messages
     * @param  Validator $validation Validation Helper
     * @param  Auth      $auth       Authentication Helper
     * @return Request               Redirect to homepage
     */
    public function postSignIn(Request $request, Response $response, Router $router, Messages $message, Validator $validation, Auth $auth)
    {
        $validate = $validation->validate($request, [
            'username' => v::notEmpty(),
            'password' => v::notEmpty()
        ]);

        if ($validate->failed()) return $response->withRedirect($router->pathFor('auth.login'));

        extract($request->getParams());

        $login = $auth->attempt($username, $password, $remember);

        if (!$login) {
            $message->addMessage('error', 'Invalid credentials, please try again!');
            return $response->withRedirect($router->pathFor('auth.login'));
        }

        $message->addMessage('success', 'You have been logged in!');
        return $response->withRedirect($router->pathFor('home'));
    }

    /**
     * Retrieves the register template
     * @param  Request  $request  Page request
     * @param  Response $response Page response
     * @param  Twig     $view     Twig view
     * @return Twig               Page template
     */
    public function getSignup(Request $request, Response $response, Twig $view)
    {
        return $view->render($response, 'auth/signup.twig');
    }

    /**
     * User sign up
     * @param  Request   $request    Page request
     * @param  Response  $response   Page response
     * @param  Router    $router     Slim Router
     * @param  Messages  $message    Flash Message
     * @param  Validator $validation Validation Helper
     * @return Response              Page response
     */
    public function postSignup(Request $request, Response $response, Router $router, Messages $message, Validator $validation)
    {
        $validate = $validation->validate($request, [
            'username' => v::notEmpty()->usernameAvailable(),
            'email' => v::notEmpty()->email()->emailAvailable(),
            'password' => v::notEmpty()->length(6, 14)
        ]);

        if ($validate->failed()) return $response->withRedirect($router->pathFor('auth.signup'));

        extract($request->getParams());

        User::create([
            'username' => $username,
            'password' => $password,
            'email'    => $email
        ]);

        $message->addMessage('success', 'You have successfully signed up! You can now login using your credentials.');
        return $response->withRedirect($router->pathFor('auth.login'));
    }

    /**
     * User logout
     * @param  Request  $request  Page request
     * @param  Response $response Page response
     * @param  Router   $router   Slim router
     * @param  Messages $message  Flash messages
     * @param  Auth     $auth     Authentication Helper
     * @return Response           Page response
     */
    public function getLogout(Request $request, Response $response, Router $router, Messages $message, Auth $auth)
    {
        if ($auth->logout()) {
            $message->addMessage('success', 'You have been signed out!');
            return $response->withRedirect($router->pathFor('home'));
        }
    }
}
