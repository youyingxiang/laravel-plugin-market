<?php
namespace Yxx\LaravelPluginMarket\Http\Requests;

class UploadImageRequest extends Request
{
    public function rules()
    {
        return [
            'file' => 'file|image|max:500'
        ];
    }
}