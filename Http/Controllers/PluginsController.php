<?php
namespace Plugins\PluginMarket\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Plugins\PluginMarket\DTOs\CreatePluginData;
use Plugins\PluginMarket\Exceptions\ApiRequestException;
use Plugins\PluginMarket\Models\MarketPlugin;
use Plugins\PluginMarket\Http\Resources\PluginResource;
use Plugins\PluginMarket\Services\plugins\Create;
use Throwable;

class PluginsController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return PluginResource::collection(MarketPlugin::query()->with('versions')->latest()->get());
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
}