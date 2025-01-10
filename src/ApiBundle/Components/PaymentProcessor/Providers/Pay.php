<?php

declare(strict_types=1);

namespace App\ApiBundle\Components\PaymentProcessor\Providers;

use Money\Money;

interface Pay
{
    public function pay(Money $productPrice): void;
}