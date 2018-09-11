<?php
namespace App\Controllers;

use App\Helpers\Pagination\Paginate as Pagination;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Views\Twig;
use Slim\Router;

use App\Models\Post;

/**
 * Home Controller
 */
class HomeController
{
    /**
     * Retrieves homepage template
     * @param  Request    $request    Page request
     * @param  Response   $response   Page response
     * @param  Twig       $view       Twig view
     * @param  Router     $router     Slim router
     * @param  Post       $post       Post model
     * @param  Pagination $pagination Pagination helper
     * @return Twig                   Page template
     */
    public function index(Request $request, Response $response, Twig $view, Router $router, Post $post, Pagination $pagination)
    {
        $pagination->limit = 2;

        $posts = $post->all();

        $paginate = $pagination->getPagination($request, $posts);
        $paginate['type'] = 1;

        extract($paginate);

        if($page > $lastpage) return $response->withRedirect($router->pathFor('home'));

        return $view->render($response, 'home.twig', [
            'pagination' => $paginate,
            'posts' => $post->orderBy('created_at', 'ASC')->limit($limit)->skip($skip)->get()
        ]);
    }
}
