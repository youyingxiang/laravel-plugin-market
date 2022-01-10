<?php
namespace Plugins\PluginMarket\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Plugins\PluginMarket\Enums\PluginVersionStatus;
use Plugins\PluginMarket\Http\Resources\PluginResource;
use Plugins\PluginMarket\Http\Resources\UserResource;
use Plugins\PluginMarket\Models\MarketPlugin;
use Plugins\PluginMarket\Models\MarketPluginVersion;

class UserController extends Controller
{
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