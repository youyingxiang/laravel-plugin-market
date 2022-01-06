<?php

namespace Plugins\PluginMarket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class MarketPluginVersion extends Model
{
    use HasFactory;

    protected $fillable = ['version', 'plugin_id', 'path',  'plugin_metadata', 'price'];

    protected $casts = [
        'plugin_metadata' => 'json'
    ];

    public function getDownloadLinkAttribute(): string
    {
        return Storage::url($this->path);
    }

    public function getDescriptionAttribute(): string
    {
        return data_get($this->plugin_metadata, 'description', '');
    }

    public function getLogoAttribute(): string
    {
        return data_get($this->plugin_metadata, 'logo', '');
    }
}
