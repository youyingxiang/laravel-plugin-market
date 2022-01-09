<?php
namespace Plugins\PluginMarket\Enums;

class PluginVersionStatus
{
    const PENDING = 0;
    const WAIT_PENDING = 1;
    const SUSPENDED = 2;
    const ACTIVE = 3;

    public static function all(): array
    {
        return [
            self::PENDING => '待审核',
            self::WAIT_PENDING => "审核中",
            self::SUSPENDED => '停用',
            self::ACTIVE => '已审核',
        ];
    }

    public static function status(int $flag): string
    {
        return data_get(self::all(), $flag);
    }
}