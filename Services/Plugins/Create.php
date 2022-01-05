<?php
namespace Plugins\PluginMarket\Services\plugins;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Plugins\PluginMarket\DTOs\CreatePluginData;
use Plugins\PluginMarket\Models\MarketPlugin;
use Plugins\PluginMarket\Models\MarketPluginVersion;
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

        $path = Str::replaceArray("?" , [$createPluginData->author, Str::uuid(), $ext], "?/?.?");

        Storage::put($path, $createPluginData->content);

        DB::transaction(function () use($createPluginData, $path) {
            $mp = MarketPlugin::query()->firstOrCreate([
                'plugin_name' => $createPluginData->pluginName,
                'author' => $createPluginData->author,
            ],[
                'type' => 1
            ]);
            MarketPluginVersion::query()->updateOrCreate([
                'version' =>  data_get($createPluginData->pluginMetadata, 'version', '1.0.0'),
                'plugin_id' => $mp->id
            ], [
                'download_link' => $path,
                'plugin_metadata' => $createPluginData->pluginMetadata,
            ]);
        });
    }
}