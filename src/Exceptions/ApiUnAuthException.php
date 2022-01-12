<?php
namespace Yxx\LaravelPluginMarket\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ApiUnAuthException extends ApiException
{
    public function __construct(string $message = null)
    {
        parent::__construct(self::AUTH_ERROR, $message ?? Response::$statusTexts[self::AUTH_ERROR]);
    }
}
