<?php

declare(strict_types=1);

namespace App\ApiBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

final class ValidationException extends BaseException
{
    public function __construct(array $errors = [])
    {
        parent::__construct(
            errors: $errors,
            message: 'Validation failed',
            code: Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}