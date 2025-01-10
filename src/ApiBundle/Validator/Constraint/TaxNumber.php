<?php
declare(strict_types=1);

namespace App\ApiBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class TaxNumber extends Constraint
{
    public string $message = 'The tax number "{{ value }}" is invalid for the specified format.';
}