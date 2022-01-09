<?php
namespace Plugins\PluginMarket\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VersionDetailResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'version' => $this->version,
            'download_link' => $this->download_link,
            'download_times' => $this->download_times,
            'type' => $this->type_str,
            'status' => $this->status_str,
            'price' => $this->price,
            'description' => $this->description,
            'logo' => $this->logo,
            'plugin_name' => $this->plugin->plugin_name
        ];
    }
}