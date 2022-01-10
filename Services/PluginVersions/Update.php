<?php
namespace Plugins\PluginMarket\Services\PluginVersions;

use Illuminate\Database\Eloquent\Builder;
use Plugins\PluginMarket\DTOs\UpdatePluginVersionData;
use Plugins\PluginMarket\Enums\PluginVersionStatus;
use Plugins\PluginMarket\Models\MarketPluginVersion;

class Update
{
    public function execute(int $versionId,int $userId, UpdatePluginVersionData $data): void
    {
        $mpv = MarketPluginVersion::query()
            ->notRelease()
            ->whereHas('plugin', fn(Builder $builder) => $builder->where('author_id', $userId))
            ->findOrFail($versionId);

        if ($data->changeStatus) {
            if (MarketPluginVersion::query()
                ->where('plugin_id', $mpv->plugin_id)
                ->where('version', $data->version)
                ->release()
                ->exists()) {
                throw new \Exception("当前版本已发布，请更换一个版本号！");
            }
            $mpv->status = PluginVersionStatus::WAIT_PENDING;
        }

        $data->logo !== null && $mpv->logo = $data->logo;
        $data->version !== null && $mpv->version = $data->version;
        $mpv->price = $data->price->amountInCent;
        $data->description !== null && $mpv->description = $data->description;

        $mpv->saveOrFail();
    }
}