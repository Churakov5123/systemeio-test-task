<?php
declare(strict_types=1);

namespace App\Tests\Component;

use App\ApiBundle\Components\PaymentProcessor\PaymentProviderRegistry;
use App\ApiBundle\Components\PaymentProcessor\Providers\Provider;
use App\ApiBundle\Exception\EntityNotFoundException;
use PHPUnit\Framework\TestCase;

class PaymentProcessorTest extends TestCase
{
    private PaymentProviderRegistry $paymentProviderRegistry;

    protected function setUp(): void
    {
        $this->paymentProviders = [
            'stripe' => $this->createMock(Provider::class),
            'paypal' => $this->createMock(Provider::class),
        ];

        $this->paymentProviderRegistry = new PaymentProviderRegistry($this->paymentProviders);
    }


    public function testGetPaymentProvider(): void
    {
        $paymentProcessor = 'stripe';

        $provider = $this->paymentProviders[$paymentProcessor];

        $result = $this->paymentProviderRegistry->getProvider($paymentProcessor);

        $this->assertSame($provider, $result);
    }


    public function testPaymentProviderEntityNotFound(): void
    {
        $paymentProcessor = 'non_existing_key';

        $this->expectException(EntityNotFoundException::class);

        $this->paymentProviderRegistry->getProvider($paymentProcessor);
    }
}