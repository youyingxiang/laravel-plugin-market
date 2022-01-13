<?php
namespace Yxx\LaravelPluginMarket\Services\Plugins;

use Illuminate\Support\Facades\Storage;
use Yxx\LaravelPluginMarket\Models\MarketPluginDownload;
use Yxx\LaravelPluginMarket\Models\MarketPluginVersion;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Download
{
    /**
     * @param  int  $versionId
     * @param  int  $userId
     * @return StreamedResponse
     */
    public function execute(int $versionId, int $userId): StreamedResponse
    {
        $mpv = MarketPluginVersion::query()->with('plugin')->findOrFail($versionId);
        MarketPluginDownload::query()->create([
            'plugin_version_id' => $mpv->id,
            'user_id' => $userId,
        ]);
        $mpv->download_times += 1;
        $mpv->plugin->download_times += 1;
        $mpv->push();
        return Storage::download($mpv->path);
    }
}