<?php

namespace Plugins\PluginMarket\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Plugins\PluginMarket\Enums\PluginVersionStatus;
use Plugins\PluginMarket\Enums\PluginVersionType;

/**
 * Class MarketPluginVersion
 * @package Plugins\PluginMarket\Models
 */
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

    public function setLogoAttribute($value): void
    {
        if ($value) {
            $pluginMetadata=  $this->plugin_metadata;
            $pluginMetadata['logo'] = $value;
            $this->attributes['plugin_metadata'] = json_encode($pluginMetadata, true);
        }
    }

    public function setDescriptionAttribute($value): void
    {
        if ($value) {
            $pluginMetadata=  $this->plugin_metadata;
            $pluginMetadata['description'] = $value;
            $this->attributes['plugin_metadata'] = json_encode($pluginMetadata, true);
        }
    }

    public function plugin():BelongsTo
    {
        return $this->belongsTo(MarketPlugin::class, 'plugin_id');
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
    public function scopeRelease(Builder $query):Builder
    {
        return $query->where('status', PluginVersionStatus::ACTIVE);
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeNotRelease(Builder $query):Builder
    {
        return $query->where('status', "<",PluginVersionStatus::ACTIVE);
    }
}
