<?php

namespace Plugins\PluginMarket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarketPluginDownload extends Model
{
    use HasFactory;

    protected $fillable = ['plugin_version_id', 'user_id'];
}
