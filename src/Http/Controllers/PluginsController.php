<?php
namespace Yxx\LaravelPluginMarket\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Yxx\LaravelPluginMarket\DTOs\CreatePluginData;
use Yxx\LaravelPluginMarket\Enums\PluginVersionStatus;
use Yxx\LaravelPluginMarket\Exceptions\ApiRequestException;
use Yxx\LaravelPluginMarket\Models\MarketPlugin;
use Yxx\LaravelPluginMarket\Http\Resources\PluginResource;
use Yxx\LaravelPluginMarket\Models\MarketPluginVersion;
use Yxx\LaravelPluginMarket\Services\Plugins\Create;
use Yxx\LaravelPluginMarket\Services\Plugins\Install;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class PluginsController extends Controller
{
    /**
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $status = $request->input('status');
        $mps = MarketPlugin::query()
            ->with(['versions', 'author'])
            ->when($status, fn(Builder $builder) =>
               $builder->whereHas('versions', fn(Builder $builder) => call_user_func([$builder, $status]))
            )
            ->latest()
            ->paginate();
        if ($status) {
            $mps->through(function(MarketPlugin $plugin) use ($status) {
                $plugin->versions = $plugin->versions->filter(fn(MarketPluginVersion $version) =>
                $status === "release" ? $version->status === PluginVersionStatus::ACTIVE : $version->status !== PluginVersionStatus::ACTIVE
                );
                return $plugin;
            });
        }

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
        return $install->execute($versionId, Auth::id());
    }

    /**
     * @return JsonResponse
     */
    public function count(): JsonResponse
    {
        return Response::json(['count' => MarketPlugin::query()->whereHas('versions', fn(Builder $builder) => $builder->release())->count()]);
    }
}