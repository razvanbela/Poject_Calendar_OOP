<?php


declare(strict_types=1);

namespace App\Entities;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping AS ORM;

#[ORM\Entity]
#[ORM\Table('bookings')]

class Booking extends BaseEntity
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\Column(name: 'data', type: Types::DATE_MUTABLE, nullable: false)]
    protected string $data;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $id_user;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $id_location;
}