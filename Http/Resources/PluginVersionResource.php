<?php
namespace Plugins\PluginMarket\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Plugins\PluginMarket\ValueObjects\Money;

class PluginVersionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'version' => $this->version,
            'download_link' => $this->download_link,
            'download_times' => $this->download_times,
            'status' => $this->status_str,
            'price' => $this->price_amount,
            'description' => $this->description,
            'logo' => $this->logo,
        ];
    }
}