<?php

declare(strict_types=1);

namespace App\ApiBundle\Components\PaymentProcessor;

/**
 * Simple factory for receiving an object by type of provider processor
 */
class PaymentProviderRegistry
{
    public array $paymentProviders;

    public function __construct(iterable $paymentProviders)
    {
        $this->paymentProviders = $paymentProviders instanceof \Traversable ? iterator_to_array($paymentProviders) : $paymentProviders;
    }

    public function getProvider(string $key)
    {
        return $this->paymentProviders[$key] ?? null;
    }

    public function getPaymentProviders(): array
    {
        return $this->paymentProviders;
    }
}