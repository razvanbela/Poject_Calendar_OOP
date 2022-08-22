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

        return $this->view->render(new Response, 'booking.twig');
    }

    protected function createBooking(array $data): Booking
    {
        $booking = new Booking();

        $location = $this->db->getRepository(Location::class)->find($data['location']);

        $resDate = \DateTime::createFromFormat('Y-m-d', $data['date']);

        $booking->fill([
            'date' => $resDate,
            'user' => $this->auth->user(),
            'location' => $location
        ]);

        $this->db->persist($booking);
        $this->db->flush();

        return $booking;
    }

    private function validateBooking(ServerRequestInterface $request): array
    {
        dd($request);
        return $this->validate($request, [
            'date' => ['required'],
            'location' => ['required']
        ]);
    }

}