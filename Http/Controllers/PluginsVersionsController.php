<?php
namespace Plugins\PluginMarket\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use Plugins\PluginMarket\DTOs\UpdatePluginVersionData;
use Plugins\PluginMarket\Exceptions\ApiRequestException;
use Plugins\PluginMarket\Http\Resources\VersionDetailResource;
use Plugins\PluginMarket\Models\MarketPluginVersion;
use Plugins\PluginMarket\Services\PluginVersions\Update;

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
            $isAdmin = Gate::allows('viewPluginMarket');
            $update->execute($versionId, Auth::id(), $isAdmin, UpdatePluginVersionData::fromRequest($request));
            return Response::json([]);
        } catch (\Exception $exception) {
            throw new ApiRequestException($exception->getMessage());
        }
    }
}