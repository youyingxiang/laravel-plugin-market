<?php
namespace Plugins\PluginMarket\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ApiSystemException extends ApiException
{
    public function __construct(string $message = null)
    {
        parent::__construct(self::SYS_ERROR, $message ?? Response::$statusTexts[self::SYS_ERROR]);
    }
}
