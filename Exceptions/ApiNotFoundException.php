<?php
namespace Plugins\PluginMarket\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ApiNotFoundException extends ApiException
{
    public function __construct(string $message = null)
    {
        parent::__construct(self::NO_FOUND_ERROR, $message ?? Response::$statusTexts[self::NO_FOUND_ERROR]);
    }
}
