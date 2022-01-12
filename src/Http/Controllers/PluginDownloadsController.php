<?php
namespace Yxx\LaravelPluginMarket\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Yxx\LaravelPluginMarket\Http\Resources\PluginDownloadResource;
use Yxx\LaravelPluginMarket\Models\MarketPluginDownload;

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