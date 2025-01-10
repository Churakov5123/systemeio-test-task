<?php
declare(strict_types=1);

namespace App\ApiBundle\Exception;

abstract class BaseException extends \RuntimeException
{
    public function __construct(protected array $errors = [], string $message, int $code)
    {
        parent::__construct($message, $code);

        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getData(): array
    {
        return [
            'errors' => $this->getErrors(),
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
        ];
    }
}