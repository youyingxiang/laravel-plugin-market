<?php

namespace Plugins\PluginMarket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarketPlugin extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $casts = [
        'plugin_metadata' => 'json'
    ];
}
