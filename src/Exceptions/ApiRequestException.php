<?php
namespace Yxx\LaravelPluginMarket\Exceptions;

use Symfony\Component\HttpFoundation\Response;


class ApiRequestException extends ApiException
{
    public function __construct(string $message = null)
    {
        parent::__construct(self::BAD_REQUEST, $message ?: Response::$statusTexts[self::BAD_REQUEST]);
    }
}
