<?php

declare(strict_types=1);

namespace App\ApiBundle\Enum;

enum PaymentStatus: string
{
    case PENDING = 'pending';
}