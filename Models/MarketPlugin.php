<?php

namespace Plugins\PluginMarket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarketPlugin extends Model
{
    use HasFactory;

    protected $fillable = ["plugin_name", "author_id"];

    /**
     * @return HasMany
     */
    public function versions(): HasMany
    {
        return $this->hasMany(MarketPluginVersion::class,"plugin_id");
    }

    /**
     * @return BelongsTo
     */
    public function author():BelongsTo
    {
        return $this->belongsTo(MarketUser::class, 'author_id');
    }

}
