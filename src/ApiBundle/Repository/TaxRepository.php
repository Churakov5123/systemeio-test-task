<?php

declare(strict_types=1);

namespace App\ApiBundle\Repository;

use App\ApiBundle\Entity\Tax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TaxRepository  extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tax::class);
    }

    public function getByCountryCode(string $countryCode): ?Tax
    {
        return $this
            ->createQueryBuilder('t')
            ->where('t.countryCode = :countryCode')
            ->setParameters(parameters: [
                'countryCode' => $countryCode,
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}