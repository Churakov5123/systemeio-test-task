<?php

declare(strict_types=1);

namespace App\ApiBundle\Components\PaymentProcessor;

use App\ApiBundle\Components\PaymentProcessor\Providers\Pay;

/**
 * In-app payment processor. Works with different payment providers.
 */
class PaymentProcessor
{
    public function __construct(
        private readonly PaymentProviderRegistry $paymentProviderRegistry,
    )
    {
    }

    public function execute(float $price, string $paymentProcessor): void
    {
        /** @var Pay $provider */
        $provider = $this->paymentProviderRegistry->getByProcessor($paymentProcessor);

        $provider->pay($price);

       //the logic of payment processing depends on the provider and is not considered
       // for further description within the framework of the task since the API is different everywhere
    }
}