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
        $getParams = $request->getQueryParams();
//      dd($getParams);
//
//        $data = $getParams['bookDate'];
//        $bookings = $this->db->getRepository(Booking::class)->matching(
//            Criteria::create()->where(Criteria::expr()->eq('bookDate', \DateTime::createFromFormat('Y-m-d', $data))->getValues()
//            )
//        );
        $bookings = $this->db->getRepository(Booking::class)->findAll();
        return $this->view->render(new Response, 'home.twig', ['bookings' => $bookings]);
    }
}