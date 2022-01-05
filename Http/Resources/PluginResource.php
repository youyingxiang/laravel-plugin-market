<?php
namespace Plugins\PluginMarket\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PluginResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->plugin_name,
            'download_link' => Storage::url($this->download_link),
        ];
    }
}