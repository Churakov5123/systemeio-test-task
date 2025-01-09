<?php

declare(strict_types=1);

namespace App\ApiBundle\Components\PaymentProcessor\Providers;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class Paypall implements Provider,Pay
{
    public function __construct(private PaypalPaymentProcessor $paymentProcessor)
    {
    }

    public function pay(float $price): void
    {
       // transform logic float to int

        $this->paymentProcessor->pay($price);
    }
}