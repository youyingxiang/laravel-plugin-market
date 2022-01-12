<?php
namespace Yxx\LaravelPluginMarket\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yxx\LaravelPluginMarket\Enums\PluginVersionStatus;
use Yxx\LaravelPluginMarket\Http\Resources\PluginResource;
use Yxx\LaravelPluginMarket\Http\Resources\UserResource;
use Yxx\LaravelPluginMarket\Models\MarketPlugin;
use Yxx\LaravelPluginMarket\Models\MarketPluginVersion;
use Yxx\LaravelPluginMarket\Models\MarketUser;

class UserController extends Controller
{

    /**
     * @return AnonymousResourceCollection
     */
    public function index():AnonymousResourceCollection
    {
        return UserResource::collection(MarketUser::query()->latest()->paginate());
    }
    /**
     * @return UserResource
     */
    public function getUserInfo(): UserResource
    {
        return new UserResource(Auth::user());
    }

    /**
     * @param  string  $status
     * @return AnonymousResourceCollection
     */
    public function getPlugins(string $status): AnonymousResourceCollection
    {
        $mps = MarketPlugin::query()
            ->with(['versions', 'author'])
            ->where('author_id', Auth::id())
            ->whereHas('versions', fn(Builder $builder) => call_user_func([$builder, $status]))
            ->get()
            ->map(function(MarketPlugin $plugin) use ($status) {
                $plugin->versions = $plugin->versions->filter(fn(MarketPluginVersion $version) =>
                    $status === "release" ? $version->status === PluginVersionStatus::ACTIVE : $version->status !== PluginVersionStatus::ACTIVE
                );
                return $plugin;
            });
        return PluginResource::collection($mps);
    }
}