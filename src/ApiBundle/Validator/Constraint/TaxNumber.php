<?php
declare(strict_types=1);

namespace App\ApiBundle\Validator\Constraint;

use App\ApiBundle\Validator\TaxNumberValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class TaxNumber extends Constraint
{
    public string $message = 'The tax number "{{ value }}" is invalid for the specified format.';
    public function validatedBy(): string
    {
        return TaxNumberValidator::class;
    }
}