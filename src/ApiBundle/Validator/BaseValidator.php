<?php

declare(strict_types=1);

namespace App\ApiBundle\Validator;

use App\ApiBundle\Dto\BaseRequestDto;
use Symfony\Component\Validator\Validator\ValidatorInterface as SymfonyValidator;
use Symfony\Component\Validator\ConstraintViolationListInterface;
class BaseValidator
{
    private SymfonyValidator $validator;

    public function __construct(SymfonyValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param BaseRequestDto $dto
     * @return array|null
     */
    public function validate(BaseRequestDto $dto): ?array
    {
        $violations = $this->validator->validate($dto);

        if (count($violations) > 0) {
            return $this->formatViolations($violations);
        }

        return null;
    }

    /**
     * Форматирует список нарушений в массив.
     *
     * @param ConstraintViolationListInterface $violations
     * @return array
     */
    private function formatViolations(ConstraintViolationListInterface $violations): array
    {
        $errors = [];

        foreach ($violations as $violation) {
            $errors[] = [
                'property' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        return $errors;
    }
}