<?php
namespace Plugins\PluginMarket\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Plugins\PluginMarket\Enums\PluginStatus;
use Plugins\PluginMarket\Enums\PluginType;

class PluginResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->plugin_name,
            'author' => optional($this->market_user)->name,
            'type' => PluginType::type($this->type),
            'versions' => PluginVersionResource::collection($this->versions),
            'status' => PluginStatus::status($this->status),
        ];
    }
}