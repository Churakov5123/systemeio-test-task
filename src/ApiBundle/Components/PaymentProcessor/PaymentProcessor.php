<?php

declare(strict_types=1);

namespace App\ApiBundle\Components\PaymentProcessor;

use App\ApiBundle\Components\PaymentProcessor\Providers\Pay;
use Money\Money;

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

    public function execute(Money $productPrice, string $paymentProcessor): void
    {
        /** @var Pay $provider */
        $provider = $this->paymentProviderRegistry->getProvider($paymentProcessor);

        $provider->pay($productPrice);

       //the logic of payment processing depends on the provider and is not considered
       // for further description within the framework of the task since the API is different everywhere
    }
}