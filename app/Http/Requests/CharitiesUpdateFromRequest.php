<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CharitiesUpdateFromRequest extends FormRequest
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
            'title' => 'string|max:20',
            'short_detail' => 'string|max:50',
            'detail_url' => 'string',
            'thumbnail_url' => 'string',
            'is_closed' => 'boolean'
        ];
    }
}
