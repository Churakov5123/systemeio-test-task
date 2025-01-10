<?php

declare(strict_types=1);

namespace App\ApiBundle\Repository;

use App\ApiBundle\Entity\Coupon;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CouponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coupon::class);
    }

    public function findByCode(string $code): ?Coupon
    {
        return $this
            ->createQueryBuilder('c')
            ->where('c.code = :code')
            ->setParameter(
                'code', $code,
            )
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}