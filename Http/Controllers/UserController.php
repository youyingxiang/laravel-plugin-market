<?php
namespace Plugins\PluginMarket\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Plugins\PluginMarket\Http\Resources\PluginResource;
use Plugins\PluginMarket\Http\Resources\UserResource;
use Plugins\PluginMarket\Models\MarketPlugin;

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
     * @return AnonymousResourceCollection
     */
    public function getPlugins(): AnonymousResourceCollection
    {
        $mps = MarketPlugin::query()
            ->with('versions')
            ->where('author_id', Auth::user()->id)
            ->latest()
            ->get();
        return PluginResource::collection($mps);
    }
}