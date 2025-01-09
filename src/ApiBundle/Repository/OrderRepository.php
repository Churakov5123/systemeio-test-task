<?php

declare(strict_types=1);

namespace App\ApiBundle\Repository;

use App\ApiBundle\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(Order $order): void
    {
        $em = $this->getEntityManager();
        $em->persist($order);
        $em->flush($order);
    }
}