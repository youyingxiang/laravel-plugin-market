<?php

namespace Plugins\PluginMarket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarketPlugin extends Model
{
    use HasFactory;

    protected $fillable = ["plugin_name", "author", "type"];

    /**
     * @return HasMany
     */
    public function versions(): HasMany
    {
        return $this->hasMany(MarketPluginVersion::class,"plugin_id");
    }

}
