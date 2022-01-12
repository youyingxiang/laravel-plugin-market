<?php
namespace Yxx\LaravelPluginMarket\Services\Plugins;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yxx\LaravelPluginMarket\DTOs\CreatePluginData;
use Yxx\LaravelPluginMarket\Models\MarketPlugin;
use Throwable;

class Create
{
    /**
     * @param  CreatePluginData  $createPluginData
     * @throws Throwable
     */
    public function execute(CreatePluginData $createPluginData): void
    {
        $path = Str::replaceArray("?" , [$createPluginData->authorId, Str::uuid()], "?/?.zip");

        Storage::put($path, $createPluginData->content);

        DB::transaction(function () use($createPluginData, $path) {
            $mp = MarketPlugin::query()->firstOrCreate([
                'plugin_name' => $createPluginData->pluginName,
                'author_id' => $createPluginData->authorId,
            ]);
            $mp->versions()->create([
                'version' =>  data_get($createPluginData->pluginMetadata, 'version', '1.0.0'),
                'path' => $path,
                'plugin_metadata' => $createPluginData->pluginMetadata,
            ]);
        });
    }
}