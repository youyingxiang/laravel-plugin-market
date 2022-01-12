<?php
namespace Plugins\PluginMarket\DTOs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Plugins\PluginMarket\Exceptions\ApiRequestException;
use Plugins\PluginMarket\ValueObjects\Money;
use Spatie\DataTransferObject\DataTransferObject;

class UpdatePluginVersionData extends DataTransferObject
{
    public int $status;
    public ?string $version;
    public Money $price;
    public ?string $description;
    public ?string $logo;

    public static function fromRequest(Request $request): self
    {
        $validator = Validator::make($request->input(), [
            'status' => 'integer',
            'price' => 'numeric'
        ]);

        if ($validator->fails()) {
            throw new ApiRequestException($validator->errors()->all()[0]);
        }

        return new self([
            'status' => (int)$request->input('status', 0),
            'version' => $request->input('version'),
            'price' => Money::withDefaultCurrency(bcmul($request->input('price', 0), 100)),
            'description' => $request->input('description'),
            'logo' => $request->input('logo'),
        ]);
    }
}