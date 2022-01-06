<?php
namespace Plugins\PluginMarket\Services\plugins;

use Illuminate\Support\Facades\Storage;
use Plugins\PluginMarket\Models\MarketPluginVersion;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Install
{
    /**
     * @param  int  $versionId
     * @return StreamedResponse
     */
    public function execute(int $versionId): StreamedResponse
    {
        $mpv = MarketPluginVersion::query()->findOrFail($versionId);
        return Storage::download($mpv->path);
    }
}