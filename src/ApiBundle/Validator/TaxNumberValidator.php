<?php

declare(strict_types=1);

namespace App\ApiBundle\Validator;


use App\ApiBundle\Validator\Constraint\TaxNumber;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
class TaxNumberValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof TaxNumber) {
            throw new \InvalidArgumentException(sprintf('Expected instance of %s', TaxNumber::class));
        }

        // Проверяем на null или пустую строку и отдаем сообщение об ошибке
        if (null === $value || '' === $value) {
            $this->context->buildViolation('Tax number cannot be null or empty.')
                ->addViolation();
            return;
        }

        // Проверяем, что значение является строкой
        if (!is_string($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->addViolation();
            return;
        }

        // Регулярные выражения для стран
        $patterns = [
            '/^DE[0-9]{9}$/' => 'Germany (DE123456789)',       // Германия
            '/^IT[0-9]{11}$/' => 'Italy (ITXXXXXXXXXXX)',      // Италия
            '/^GR[0-9]{9}$/' => 'Greece (GRXXXXXXXXX)',        // Греция
            '/^FR[A-Z]{2}[0-9]{9}$/' => 'France (FRYYXXXXXXXXX)', // Франция
        ];

        // Проверяем, соответствует ли значение одному из форматов
        $isValid = false;
        foreach ($patterns as $pattern => $country) {
            if (preg_match($pattern, $value)) {
                $isValid = true;
                break;
            }
        }

        if (!$isValid) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->addViolation();
        }
    }
}