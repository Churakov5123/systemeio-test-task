<?php

declare(strict_types=1);

namespace App\ApiBundle\Entity;

use App\ApiBundle\Enum\CouponType;

/**
 * @ORM\Table(name="coupon")
 * @ORM\Entity(repositoryClass="App\ApiBundle\Repository\CouponRepository")
 */
class Coupon
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @see CouponType
     *
     * @var string
     *
     * @ORM\Column(name="`type`", type="string")
     */
    private string $type;

    /**
     * @ORM\Column(name="code", type="string", length=10)
     */
    private string $code;

    /**
     * @var float
     * @ORM\Column(name="discount_amount", type="decimal", precision=10, scale=2, nullable=true)
     */
    private float $discountAmount;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private \DateTime $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private \DateTime $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getType(): CouponType
    {
        return CouponType::from($this->type);
    }

    public function setType(CouponType $type): void
    {
        $this->type = $type->value;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getDiscountAmount(): float
    {
        return $this->discountAmount;
    }

    public function setDiscountAmount(float $discountAmount): void
    {
        $this->discountAmount = $discountAmount;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}