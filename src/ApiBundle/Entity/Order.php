<?php

declare(strict_types=1);

namespace App\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\ApiBundle\Enum\PaymentStatus;

#[ORM\Entity(repositoryClass: 'App\ApiBundle\Repository\OrderRepository')]
#[ORM\Table(name: '"order"')]
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

    #[ORM\Column(name: 'payment_processor', type: 'string')]
    private string $paymentProcessor;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private \DateTime $createdAt;

    /**
     * @param \DateTime $createdAt
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }


    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    public function getStatus(): PaymentStatus
    {
        return PaymentStatus::from($this->status);
    }

    public function setStatus(PaymentStatus $status): void
    {
        $this->status = $status->value;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }

    public function setPaymentProcessor(string $paymentProcessor): void
    {
        $this->paymentProcessor = $paymentProcessor;
    }
}