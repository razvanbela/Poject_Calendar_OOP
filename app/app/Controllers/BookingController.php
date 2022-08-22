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

        $this->validateDate($data);

        $this->validateLocation($data);

        $this->createBooking($data);

        return redirect($this->router->getNamedRoute('booking')->getPath());
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

        return $this->validate($request, [
            'date' => ['required'],
            'location' => ['required']
        ]);
    }

    private function validateDate(array $data)
    {
        $resDate = new \DateTime;
        $resDate = $resDate->format('Y-m-d');

         if ($resDate <= $data['date']) {
         dd('Nu se poate');
        }
        dd('da');
    }

    private function validateLocation(array $data)
    {
        $resDate = \DateTime::createFromFormat('Y-m-d', $data['date']);
        $location = $this->db->getRepository(Location::class)->find($data['location']);

        //dd($resDate, $location);
    }
}