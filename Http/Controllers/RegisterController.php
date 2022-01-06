<?php

namespace Plugins\PluginMarket\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Plugins\PluginMarket\Models\MarketUser;
use Plugins\PluginMarket\Http\Requests\User\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * @param  RegisterRequest  $request
     * @return Response
     */
    public function register(RegisterRequest $request): Response
    {
        $params = $request->validated();

        $user = MarketUser::query()->create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => Hash::make($params['password']),
        ]);
        event(new Registered($user));

        return response(["token" => $user->createToken($params['email'])->plainTextToken]);
    }
}
