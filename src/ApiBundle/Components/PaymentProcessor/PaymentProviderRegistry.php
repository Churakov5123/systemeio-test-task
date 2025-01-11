<?php

declare(strict_types=1);

namespace App\ApiBundle\Components\PaymentProcessor;

use App\ApiBundle\Components\PaymentProcessor\Providers\Provider;
use App\ApiBundle\Exception\EntityNotFoundException;

/**
 * Simple factory for receiving an object by type of provider processor
 */
class PaymentProviderRegistry
{
    /**
     * @var Provider[]
     */
    public array $paymentProviders;

    public function __construct(iterable $paymentProviders)
    {
        $this->paymentProviders = $paymentProviders instanceof \Traversable ? iterator_to_array($paymentProviders) : $paymentProviders;
    }

    /**
     * @param string $key
     *
     * @return Provider
     *
     * @throws EntityNotFoundException
     */
    public function getProvider(string $key): Provider
    {
        $provider = $this->paymentProviders[$key] ?? null;

        if (null === $provider) {
            return throw new EntityNotFoundException();
        }

        return $provider;
    }

    /**
     * @return Provider[]
     */
    public function getPaymentProviders(): array
    {
        return $this->paymentProviders;
    }
}