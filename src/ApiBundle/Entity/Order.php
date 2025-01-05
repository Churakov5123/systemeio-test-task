<?php

declare(strict_types=1);

namespace App\ApiBundle\Entity;

class Order
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @var float|null
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2, nullable=true)
     */
    private ?float $amount = null;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_date", type="datetime")
     */
    private \DateTime $createdAt;
}