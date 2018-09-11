<?php
session_start();

use Illuminate\Database\Capsule\Manager as Capsule;

use App\App;

use Respect\Validation\Validator as v;

use App\Helpers\Authentication\Auth;

use Slim\Views\Twig;
use Slim\Flash\Messages;
use Slim\Router;
use Slim\Csrf\Guard;


use App\Middleware\UserMiddleware;
use App\Middleware\OldInputMiddleware;
use App\Middleware\ValidationErrorsMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new App();

$container = $app->getContainer();

$twig = $container->get(Twig::class);
$router = $container->get(Router::class);
$flash = $container->get(Messages::class);
$auth = $container->get(Auth::class);
$guard = $container->get(Guard::class);

$capsule = new Capsule;

$capsule->addConnection([
	'driver' => 'mysql',
	'host' => 'localhost',
	'database' => 'blog',
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix' => ''
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

require_once __DIR__ . '/../app/routes.php';

$app->add(new UserMiddleware($twig, $auth));
$app->add(new OldInputMiddleware($twig));
$app->add(new ValidationErrorsMiddleware($twig));
$app->add($guard);

v::with('App\\Helpers\\Validation\\Rules\\');
