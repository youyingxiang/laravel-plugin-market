<?php

namespace Yxx\LaravelPluginMarket\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MarketUser extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute(): string
    {
        return 'https://ui-avatars.com/api/?name='.$this->name.'color=7F9CF5&background=EBF4FF';
    }

    public function getIsAdminAttribute(): bool
    {
        return Gate::allows('admin');
    }

    public function getNotAdminAttribute(): bool
    {
        return Gate::denies('admin');
    }
}
