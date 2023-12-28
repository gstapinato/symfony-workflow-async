<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ServiceHttpException extends HttpException
{
    protected function __construct(int $statusCode, string $message = '', \Throwable|null $previous = null)
    {
        parent::__construct($statusCode, $message, $previous);
    }

    public static function createValidationException(string $message = '', \Throwable|null $previous = null): self
    {
        return new self(Response::HTTP_UNPROCESSABLE_ENTITY, $message, $previous);
    }
    public static function createNotFoundException(string $message = '', \Throwable|null $previous = null): self
    {
        return new self(Response::HTTP_NOT_FOUND, $message, $previous);
    }

}
