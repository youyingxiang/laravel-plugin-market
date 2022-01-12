<?php
namespace Yxx\LaravelPluginMarket\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Yxx\LaravelPluginMarket\Exceptions\ApiRequestException;

abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @param  Validator  $validator
     * @throws ApiRequestException
     */
    protected function failedValidation(Validator $validator)
    {
        $error = $validator->errors()->all();
        throw new ApiRequestException($error[0]);
    }
}