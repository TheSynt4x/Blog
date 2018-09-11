<?php
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->get('/', ['App\Controllers\HomeController', 'index'])->setName('home');

$app->get('/post/{id}', ['App\Controllers\BlogController', 'getPost'])->setName('blog.post');
$app->post('/post/{id}', ['App\Controllers\BlogController', 'postComment']);

$app->group('', function() use($app) {
    $app->get('/login', ['App\Controllers\AuthController', 'getSignIn'])->setName('auth.login');
    $app->post('/login', ['App\Controllers\AuthController', 'postSignIn']);

    $app->get('/signup', ['App\Controllers\AuthController', 'getSignup'])->setName('auth.signup');
    $app->post('/signup', ['App\Controllers\AuthController', 'postSignup']);
})->add(new GuestMiddleware($flash, $router));

$app->get('/logout', ['App\Controllers\AuthController', 'getLogout'])->setName('auth.logout');
