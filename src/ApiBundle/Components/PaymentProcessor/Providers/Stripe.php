<?php
declare(strict_types=1);

namespace App\ApiBundle\Components\PaymentProcessor\Providers;

use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class Stripe implements Provider,Pay
{
    public function __construct(private StripePaymentProcessor $paymentProcessor)
    {
    }

    public function pay(float $price): void
    {
        $result = $this->paymentProcessor->processPayment($price);

        if ($result) {
            //some logic for handle
        } else {
            //some logic for handle
        }
    }
}