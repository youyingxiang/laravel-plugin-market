<?php

namespace Plugins\PluginMarket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class MarketPluginVersion extends Model
{
    use HasFactory;

    protected $fillable = ['version', 'plugin_id', 'download_link',  'plugin_metadata', 'price'];

    protected $casts = [
        'plugin_metadata' => 'json'
    ];

    public function getDownloadLinkAttribute($value): string
    {
        return Storage::url($value);
    }

    public function getDescriptionAttribute(): string
    {
        return data_get($this->plugin_metadata, 'description', '');
    }

    public function getLogAttribute(): string
    {
        return data_get($this->plugin_metadata, 'log', '');
    }
}
