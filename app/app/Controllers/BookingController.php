<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Auth\Auth;

use App\Session\Flash;
use App\Views\View;
use Laminas\Diactoros\Response;
use League\Route\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BookingController extends Controller
{

    public function __construct(
        protected View $view,
        protected Auth $auth,
        protected Router $router,
        protected Flash $flash
    ) {
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return $this->view->render(new Response, 'booking.twig');
    }
    /*  public function store(ServerRequestInterface $request): ResponseInterface
    {
      $data = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $attempt = $this->auth->attempt($data['email'], $data['password'], isset($data['remember']));

        if (!$attempt) {
            $this->flash->now('error', 'Could not sign you in with those details');

            return redirect($request->getUri()->getPath());
        }

        return redirect($this->router->getNamedRoute('home')->getPath());
    }*/
}