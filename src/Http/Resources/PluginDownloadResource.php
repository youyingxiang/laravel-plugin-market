<?php
namespace Yxx\LaravelPluginMarket\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PluginDownloadResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user->name,
            'plugin_name' => $this->version->plugin->plugin_name,
            'plugin_version' => $this->version->version,
            'price' => $this->version->price_amount,
            'time' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}