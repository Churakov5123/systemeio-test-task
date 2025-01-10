<?php

declare(strict_types=1);

namespace App\ApiBundle\Components\PaymentProcessor\Providers;

use Money\Money;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class Paypall implements Provider,Pay
{
    public function __construct(private PaypalPaymentProcessor $paymentProcessor)
    {
    }

    public function pay(Money $productPrice): void
    {
       // transform logic float to int

        $this->paymentProcessor->pay(intval($productPrice->getAmount()));
    }
}