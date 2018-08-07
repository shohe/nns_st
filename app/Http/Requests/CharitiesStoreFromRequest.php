<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CharitiesStoreFromRequest extends FormRequest
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
            'title' => 'required|string|max:20',
            'short_detail' => 'required|string|max:50',
            'detail_url' => 'required|string',
            'thumbnail_url' => 'required|string'
        ];
    }
}
