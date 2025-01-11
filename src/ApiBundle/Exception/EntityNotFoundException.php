<?php
declare(strict_types=1);

namespace App\ApiBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

final class EntityNotFoundException extends BaseException
{
    public function __construct(array $errors = [])
    {
        parent::__construct(
            errors: $errors,
            message: 'Entity not found.',
            code: Response::HTTP_NOT_FOUND
        );
    }
}