<?php
namespace Yxx\LaravelPluginMarket\Http\Requests\User;

use Yxx\LaravelPluginMarket\Http\Requests\Request;

class LoginRequest extends Request
{
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}