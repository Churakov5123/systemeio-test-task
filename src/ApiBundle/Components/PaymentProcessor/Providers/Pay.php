<?php

declare(strict_types=1);

namespace App\ApiBundle\Components\PaymentProcessor\Providers;

use Money\Money;

/**
 * Basic payment interface for providers used by the application
 */
interface Pay
{
    public function pay(Money $productPrice): void;
}