<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Auth\Auth;

use App\Entities\Booking;
use App\Entities\Location;
use App\Entities\User;
use App\Session\Flash;
use App\Views\View;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Laminas\Diactoros\Response;
use League\Route\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BookingController extends Controller
{

    public function __construct(
        protected View          $view,
        protected Auth          $auth,
        protected Router        $router,
        protected Flash         $flash,
        protected EntityManager $db
    )
    {
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $locations = $this->db->getRepository(Location::class)->findAll();

        return $this->view->render(new Response, 'booking.twig', ['locations' => $locations]);
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $data = $this->validateBooking($request);

        $this->createBooking($data);

        return redirect($this->router->getNamedRoute('home')->getPath());
    }

    protected function createBooking(array $data): Booking
    {
        $booking = new Booking();

        $id_user = $this->db->getRepository(User::class)->find('id');

        $id_location = $this->db->getRepository(Location::class)->find('id');

        $booking->fill([
            'date' => $data['date'],
            'id_user' => $data[$id_user],
            'id_location' => $data[$id_location],
            'time' => $data['time']
        ]);

        $this->db->persist($booking);
        $this->db->flush();

        return $booking;
    }

    private function validateBooking(ServerRequestInterface $request): array
    {
        return $this->validate($request, [
            'address' => ['required'],
            'date' => ['required'],
            'time' => ['required']
        ]);
    }

}