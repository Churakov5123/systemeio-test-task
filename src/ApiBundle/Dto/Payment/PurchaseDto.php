<?php
declare(strict_types=1);

namespace App\ApiBundle\Dto\Payment;

use Symfony\Component\Validator\Constraints as Assert;

class PurchaseDto extends CalculatePriceDto
{
    #[Assert\NotBlank(message: "Payment processor is required.")]
    #[Assert\Type(type: "string", message: "Payment processor must be a string.")]
    #[Assert\Choice(
        choices: ["paypal", "stripe"],
        message: "The payment processor must be either 'paypal' or 'stripe'."
    )]
    protected string $paymentProcessor;

    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }

    public function setPaymentProcessor(string $paymentProcessor): void
    {
        $this->paymentProcessor = $paymentProcessor;
    }
}