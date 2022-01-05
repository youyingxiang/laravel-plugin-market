<?php
namespace Plugins\PluginMarket\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Plugins\PluginMarket\Enums\PluginType;

class PluginResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->plugin_name,
            'author' => $this->author,
            'type' => PluginType::type($this->type),
            'versions' => PluginVersionResource::collection($this->versions),
        ];
    }
}