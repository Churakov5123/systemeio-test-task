<?php
declare(strict_types=1);

namespace App\ApiBundle\Dto\Payment;

use App\ApiBundle\Dto\BaseDto;
use Symfony\Component\Validator\Constraints as Assert;
use App\ApiBundle\Validator\Constraint as ApiBundleAssert;;

class PurchaseDto extends BaseDto
{
    #[Assert\NotBlank(message: "Product ID is required.")]
    #[Assert\Type(type: "integer", message: "The product ID must be an integer.")]
    private int $product;

    #[Assert\NotBlank(message: "Tax number is required.")]
    #[ApiBundleAssert\TaxNumber]
    #[Assert\Type(type: "string", message: "Tax number must be a string.")]
    private string $taxNumber;

    #[Assert\NotBlank(message: "Coupon code is required.")]
    #[Assert\Regex(
        pattern: "/^[A-Z]{1}\d{2}$/",
        message: "The coupon code must be a letter followed by 2 digits (e.g., D15)."
    )]
    #[Assert\Type(type: "string", message: "Coupon code must be a string.")]
    private string $couponCode;

    #[Assert\NotBlank(message: "Payment processor is required.")]
    #[Assert\Type(type: "string", message: "Payment processor must be a string.")]
    #[Assert\Choice(
        choices: ["paypal", "stripe"],
        message: "The payment processor must be either 'paypal' or 'stripe'."
    )]
    private string $paymentProcessor;

    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }

    public function setPaymentProcessor(string $paymentProcessor): void
    {
        $this->paymentProcessor = $paymentProcessor;
    }
}