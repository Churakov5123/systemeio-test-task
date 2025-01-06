<?php

declare(strict_types=1);

namespace App\ApiBundle\Dto\Payment;

use App\ApiBundle\Dto\BaseRequestDto;
use Symfony\Component\Validator\Constraints as Assert;
class CalculatePriceDto extends BaseRequestDto
{
    #[Assert\NotBlank(message: "Product ID is required.")]
    #[Assert\Type(type: "integer", message: "The product ID must be an integer.")]
    private int $product;

    #[Assert\NotBlank(message: "Tax number is required.")]
    #[Assert\Regex(
        pattern: "/^DE\d{9}$/",
        message: "The tax number must start with 'DE' followed by 9 digits."
    )]
    #[Assert\Type(type: "string", message: "Tax number must be a string.")]
    private string $taxNumber; // тут нужно делать отдельный валидатор для номера потому как регулярко не правильно валидировать. В следующем комите реализую

    #[Assert\NotBlank(message: "Coupon code is required.")]
    #[Assert\Regex(
        pattern: "/^[A-Z]{1}\d{2}$/",
        message: "The coupon code must be a letter followed by 2 digits (e.g., D15)."
    )]
    #[Assert\Type(type: "string", message: "Coupon code must be a string.")]
    private string $couponCode;

    public function getProduct(): int
    {
        return $this->product;
    }

    public function setProduct(int $product): void
    {
        $this->product = $product;
    }

    public function getCouponCode(): string
    {
        return $this->couponCode;
    }

    public function setCouponCode(string $couponCode): void
    {
        $this->couponCode = $couponCode;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(string $taxNumber): void
    {
        $this->taxNumber = $taxNumber;
    }
}