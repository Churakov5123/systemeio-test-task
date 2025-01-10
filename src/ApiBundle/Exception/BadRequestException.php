<?php
declare(strict_types=1);

namespace App\ApiBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

final class BadRequestException extends BaseException
{
    public function __construct(array $errors = [])
    {
        parent::__construct(errors: $errors, message: 'Bad request', code: Response::HTTP_BAD_REQUEST);
    }
}