<?php
namespace Plugins\PluginMarket\Services\Plugins;

use Illuminate\Support\Facades\DB;
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

        $path = Str::replaceArray("?" , [$createPluginData->authorId, Str::uuid(), $ext], "?/?.?");

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