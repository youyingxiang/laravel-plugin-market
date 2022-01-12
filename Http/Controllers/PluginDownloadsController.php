<?php
namespace Plugins\PluginMarket\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Plugins\PluginMarket\Http\Resources\PluginDownloadResource;
use Plugins\PluginMarket\Models\MarketPluginDownload;

class PluginDownloadsController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return PluginDownloadResource::collection(MarketPluginDownload::query()->with('version', 'user', 'version.plugin')->latest()->paginate());
    }
}