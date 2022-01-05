<?php
namespace Plugins\PluginMarket\Services\plugins;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Plugins\PluginMarket\DTOs\CreatePluginData;
use Plugins\PluginMarket\Models\MarketPlugin;
use Symfony\Component\Mime\MimeTypes;
use Throwable;

class Create
{
    /**
     * @param  CreatePluginData  $createPluginData
     * @throws Throwable
     */
    public function execute(CreatePluginData $createPluginData): void
    {
        $ext = data_get((new MimeTypes())->getExtensions($createPluginData->contentType), 0);

        $path = Str::replaceArray("?" , [1, Str::uuid(), $ext], "?/?.?");

        Storage::put($path, $createPluginData->content);

        $mp = MarketPlugin::query()->newModelInstance();
        $mp->plugin_name = $createPluginData->pluginName;
        $mp->market_user_id = $createPluginData->marketUserId;
        $mp->download_link = $path;
        $mp->type = 1;
        $mp->plugin_metadata = $createPluginData->pluginMetadata;
        $mp->saveOrFail();
    }
}