<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Views\View;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LocationController
{
    public function __construct(protected View $view)
    {
    }

}