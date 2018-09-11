<?php
namespace App\Controllers;

use App\Helpers\Validation\Validator;
use App\Helpers\Pagination\Paginate as Pagination;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Respect\Validation\Validator as v;

use Slim\Views\Twig;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

use Slim\Router;

/**
 * Blog Controller
 */
class BlogController
{
    /**
     * User data
     * @var object
     */
    protected $user;

    /**
     * Class constructor
     */
    public function __construct()
    {
        if (isset($_COOKIE['user'])) $this->user = User::find($_COOKIE['user']);
    }

    /**
     * Retrieves all posts for the blog route
     * @param  Request  $request  Page request
     * @param  Response $response Page response
     * @return Twig               Page template
     */
    public function getBlog(Request $request, Response $response)
    {
        $posts = Post::all();

        return $view->render($response, 'home.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * Retrives a single post for the blog post route
     * @param  int      $id       Blog post id
     * @param  Request  $request  Page request
     * @param  Response $response Page response
     * @param  Twig     $view     Twig view
     * @param  Router   $router   Slim router
     * @param  Pagination $pagination Pagination helper
     * @return Twig               Page template
     */
    public function getPost($id, Request $request, Response $response, Twig $view, Router $router, Pagination $pagination)
    {
        $pagination->limit = 5;

        $post = Post::where('id', $id)->first();

        if(!$post->count()) return $response->withRedirect($router->pathFor('home'));

        $paginate = $pagination->getPagination($request, $post->comments());
        $paginate['type'] = 1;

        extract($paginate);

        if($page > $lastpage) return $response->withRedirect($router->pathFor('home'));

        return $view->render($response, 'blog/post.twig', [
            'pagination' => $paginate,
            'post' => $post,
            'comments' => $post->comments()->skip($skip)->limit($limit)->get()
        ]);
    }

    public function postComment($id, Request $request, Response $response, Twig $view, Router $router, Validator $validation)
    {
        $post = Post::where('id', $id);

        if (!$post->count()) return $response->withRedirect($router->pathFor('home'));

        $validate = $validation->validate($request, [
            'comment' => v::notEmpty()->length(0, 100)
        ]);

        if ($validate->failed()) return $response->withRedirect($router->pathFor('blog.post', ['id' => $id]));

        Comment::create([
            'post_id' => $id,
            'username' => $this->user->username,
            'comment' => $request->getParam('comment')
        ]);

        return $response->withRedirect($router->pathFor('blog.post', ['id' => $id]));
    }
}
