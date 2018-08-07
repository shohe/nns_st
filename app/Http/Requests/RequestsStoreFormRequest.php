<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestsStoreFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // TODO: authorize implementation
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'offer_id' => 'required|integer',
            'price' => 'required|integer',
            'comment' => 'string|max:255'
        ];
    }
}
