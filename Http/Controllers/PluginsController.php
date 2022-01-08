<?php
namespace Plugins\PluginMarket\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Plugins\PluginMarket\DTOs\CreatePluginData;
use Plugins\PluginMarket\Enums\PluginVersionStatus;
use Plugins\PluginMarket\Exceptions\ApiRequestException;
use Plugins\PluginMarket\Models\MarketPlugin;
use Plugins\PluginMarket\Http\Resources\PluginResource;
use Plugins\PluginMarket\Models\MarketPluginVersion;
use Plugins\PluginMarket\Services\Plugins\Create;
use Plugins\PluginMarket\Services\Plugins\Install;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class PluginsController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $mps = MarketPlugin::query()
            ->with(['versions', 'author'])
            ->get()
            ->map(function (MarketPlugin $plugin){
                $plugin->versions =  $plugin->versions->filter(function (MarketPluginVersion $version){
                    return $version->status === PluginVersionStatus::ACTIVE;
                });
                return $plugin;
            })
            ->filter(function (MarketPlugin $plugin){
                return $plugin->versions->isNotEmpty();
            });
        return PluginResource::collection($mps);
    }

    /**
     * @param  Request  $request
     * @param  Create  $create
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(Request $request, Create $create): JsonResponse
    {
        try {
            $create->execute(CreatePluginData::fromRequest($request));
            return Response::json([]);
        } catch (\Exception $exception) {
            throw new ApiRequestException($exception->getMessage());
        }
    }

    /**
     * @param  int  $versionId
     * @param  Install  $install
     * @return StreamedResponse
     */
    public function install(int $versionId, Install $install): StreamedResponse
    {
        return $install->execute($versionId);
    }

    /**
     * @return JsonResponse
     */
    public function count(): JsonResponse
    {
        return Response::json(['count' => MarketPlugin::query()->count()]);
    }
}