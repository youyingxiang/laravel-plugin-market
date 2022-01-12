<?php
namespace Yxx\LaravelPluginMarket\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Yxx\LaravelPluginMarket\DTOs\UpdatePluginVersionData;
use Yxx\LaravelPluginMarket\Exceptions\ApiRequestException;
use Yxx\LaravelPluginMarket\Http\Resources\VersionDetailResource;
use Yxx\LaravelPluginMarket\Models\MarketPluginVersion;
use Yxx\LaravelPluginMarket\Services\PluginVersions\Update;

class PluginsVersionsController extends Controller
{
    /**
     * @param  int  $versionId
     * @return VersionDetailResource
     */
    public function show(int $versionId):VersionDetailResource
    {
        return new VersionDetailResource(MarketPluginVersion::query()->findOrFail($versionId));
    }

    /**
     * @param  int  $versionId
     * @param  Request  $request
     * @param  Update  $update
     * @return JsonResponse
     */
    public function update(int $versionId, Request $request, Update $update): JsonResponse
    {
        try {
            $isAdmin = Auth::user()->is_admin;
            $update->execute($versionId, Auth::id(), $isAdmin, UpdatePluginVersionData::fromRequest($request));
            return Response::json([]);
        } catch (\Exception $exception) {
            throw new ApiRequestException($exception->getMessage());
        }
    }
}