<?php
namespace Plugins\PluginMarket\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PluginResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->plugin_name,
            'author' => optional($this->author)->name,
            'download_times' => $this->download_times,
            'versions' => PluginVersionResource::collection($this->versions),
        ];
    }
}