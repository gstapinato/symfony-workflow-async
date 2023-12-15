<?php declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ServiceException extends HttpException
{
    protected function __construct(int $statusCode, string $message = '')
    {
        parent::__construct($statusCode, $message);
    }

    public static function createValidationException(string $message = ''): self
    {
        return new self(Response::HTTP_UNPROCESSABLE_ENTITY, $message);
    }
    public static function createNotFoundException(string $message = ''): self
    {
        return new self(Response::HTTP_NOT_FOUND, $message);
    }

}