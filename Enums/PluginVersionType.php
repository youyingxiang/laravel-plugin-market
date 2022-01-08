<?php
namespace Plugins\PluginMarket\Enums;

class PluginVersionType
{
    const FREE = 0;
    const CHARGE = 1;

    public static function all(): array
    {
        return [
            self::FREE => '免费',
            self::CHARGE => '付费',
        ];
    }

    public static function type(int $flag): string
    {
        return data_get(self::all(), $flag);
    }
}