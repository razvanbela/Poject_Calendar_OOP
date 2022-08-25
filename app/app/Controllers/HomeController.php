<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Entities\Booking;
use App\Entities\Location;
use App\Entities\User;
use App\Views\View;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\Response;
use mysql_xdevapi\DatabaseObject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{
    public function __construct(
        protected View          $view,
        protected EntityManager $db
    )
    {
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return $this->view->render(new Response, 'home.twig');
    }

    private function prepareForJson(array $bookings): array
    {
        $data = [];
        foreach ($bookings as $booking) {
            $data[] = [
                "id" => $booking->id,
                "name" => $booking->user->name,
                "date" => $booking->date,
                "location" => $booking->location,
            ];
        }
        return $data;
    }

    public function getBookings(ServerRequestInterface $request): ResponseInterface
    {
        $date = $request->getQueryParams()['date'] ?? date('Y-m-d');
dd(\DateTime::createFromFormat('Y-m-d', $date));
        $bookings = $this->db->getRepository(Booking::class)->findBy([
            'date' => \DateTime::createFromFormat('Y-m-d', $date)
        ]);
        return new Response\JsonResponse($this->prepareForJson($bookings));
    }
}