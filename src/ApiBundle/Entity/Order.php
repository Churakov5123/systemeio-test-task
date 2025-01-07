<?php

declare(strict_types=1);

namespace App\ApiBundle\Entity;

/**
 * @ORM\Table(name="order")
 *
 * @ORM\Entity(repositoryClass="App\ApiBundle\Repository\OrderRepository")
 */
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
     * @see PaymentStatus
     *
     * @var string
     *
     * @ORM\Column(name="status", type="string")
     */
    private string $status;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private \DateTime $createdAt;
}