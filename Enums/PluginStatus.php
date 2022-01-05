<?php
namespace Plugins\PluginMarket\Enums;

class PluginStatus
{
    const PENDING = 0;
    const WAIT_PENDING = 1;
    const ACTIVE = 2;
    const SUSPENDED = 3;

    public static function all(): array
    {
        return [
            self::PENDING => '待审核',
            self::WAIT_PENDING => "审核中",
            self::ACTIVE => '已审核',
            self::SUSPENDED => '停用'
        ];
    }

    public static function status(int $flag): string
    {
        return data_get(self::all(), $flag);
    }
}