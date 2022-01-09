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

        $data->logo !== null && $mpv->logo = $data->logo;
        $data->version !== null && $mpv->version = $data->version;
        $data->price !== null && $mpv->price = $data->price;
        $data->description !== null && $mpv->description = $data->description;
        if ($data->changeStatus) {
            $mpv->status = PluginVersionStatus::WAIT_PENDING;
        }

        $mpv->saveOrFail();
    }
}