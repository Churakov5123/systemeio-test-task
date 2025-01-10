<?php
declare(strict_types=1);

namespace App\ApiBundle\Components\PaymentProcessor\Providers;

use Money\Money;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class Stripe implements Provider,Pay
{
    public function __construct(private StripePaymentProcessor $paymentProcessor)
    {
    }

    public function pay(Money $productPrice): void
    {
        $result = $this->paymentProcessor->processPayment(floatval($productPrice->getAmount()));

        if ($result) {
            //some logic for handle
        } else {
            //some logic for handle
        }
    }
}