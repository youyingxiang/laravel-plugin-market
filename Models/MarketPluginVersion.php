<?php

namespace Plugins\PluginMarket\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Plugins\PluginMarket\Enums\PluginVersionStatus;
use Plugins\PluginMarket\Enums\PluginVersionType;

class MarketPluginVersion extends Model
{
    use HasFactory;

    protected $fillable = ['version', 'plugin_id', 'path',  'plugin_metadata', 'price', 'type', 'status'];

    protected $casts = [
        'plugin_metadata' => 'json'
    ];

    public function getDownloadLinkAttribute(): string
    {
        return Storage::url($this->path);
    }

    public function getTypeStrAttribute(): string
    {
        return PluginVersionType::type($this->type);
    }

    public function getStatusStrAttribute(): string
    {
        return PluginVersionStatus::status($this->status);
    }

    public function getDescriptionAttribute(): string
    {
        return data_get($this->plugin_metadata, 'description', '');
    }

    public function getLogoAttribute(): string
    {
        return data_get($this->plugin_metadata, 'logo', '');
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeActive(Builder $query):Builder
    {
        return $query->where('status', PluginVersionStatus::ACTIVE);
    }
}
