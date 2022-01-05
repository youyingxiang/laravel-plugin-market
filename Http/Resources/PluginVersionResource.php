<?php
namespace Plugins\PluginMarket\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PluginVersionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'version' => $this->version,
            'download_link' => $this->download_link,
            'download_times' => $this->download_times,
            'price' => $this->price,
            'description' => $this->description,
            'logo' => $this->log,
        ];
    }
}