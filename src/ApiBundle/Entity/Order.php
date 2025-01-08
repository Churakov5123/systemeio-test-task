<?php

declare(strict_types=1);

namespace App\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\ApiBundle\Enum\PaymentStatus;

#[ORM\Entity(repositoryClass: 'App\ApiBundle\Repository\OrderRepository')]
#[ORM\Table(name: 'order')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'amount', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?float $amount = null;

    #[ORM\Column(name: 'status', type: 'string')]
    private string $status;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private \DateTime $createdAt;
}