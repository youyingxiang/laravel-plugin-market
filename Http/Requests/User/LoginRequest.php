<?php
namespace Plugins\PluginMarket\Http\Requests\User;

use Plugins\PluginMarket\Http\Requests\Request;

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