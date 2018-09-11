<?php
use Interop\Container\ContainerInterface;

use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Slim\Flash\Messages;
use Slim\Csrf\Guard;

use App\Views\CsrfExtension;

use App\Helpers\Pagination\Paginate;
use App\Helpers\Authentication\Auth;

use App\Models\User;

return
[
    Auth::class => function(ContainerInterface $c)
    {
        return new Auth();
    },
    Twig::class => function(ContainerInterface $c)
    {
        $twig = new Twig(__DIR__ . '/../resources/views', [
            'cache' => false
        ]);

        $twig->addExtension(new TwigExtension(
            $c->get('router'),
            $c->get('request')->getUri()
        ));

        $twig->addExtension(new CsrfExtension($c->get(Guard::class)));

        $twig->getEnvironment()->addGlobal('title', 'Blog');

        $twig->getEnvironment()->addGlobal('flash', $c->get(Messages::class));

        return $twig;
    },
    Guard::class => function(ContainerInterface $c)
    {
        return new Guard();
    },
    Messages::class => function(ContainerInterface $c)
    {
        return new Messages();
    },
    Paginate::class => function(ContainerInterface $c)
    {
        return new Paginate();
    }
];
