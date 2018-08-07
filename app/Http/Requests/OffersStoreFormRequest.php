<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffersStoreFormRequest extends FormRequest
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
            'menu' => 'required|string|max:20',
            'price' => 'required|integer',
            'date_time' => 'required|date_format:Y-m-d H:i:s',
            'distance_range' => 'required|integer',
            'user_location' => 'required',
            'stylist_id' => 'integer',
            'hair_type' => 'required|integer',
            'comment' => 'string|max:255',
            'charity_id' => 'required|integer'
        ];
    }
}
