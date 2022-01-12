<?php
namespace Yxx\LaravelPluginMarket\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PluginVersionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'version' => $this->version,
            'download_link' => $this->download_link,
            'download_times' => $this->download_times,
            'status' => $this->status,
            'status_str' => $this->status_str,
            'price' => $this->price_amount,
            'description' => $this->description,
            'logo' => $this->logo,
        ];
    }
}