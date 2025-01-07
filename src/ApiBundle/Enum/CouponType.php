<?php

declare(strict_types=1);

namespace App\ApiBundle\Enum;

enum CouponType: string
{
    case PERCENT = 'percent';
    case FIXED_AMOUNT = 'fixed_amount';
}
