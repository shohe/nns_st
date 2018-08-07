<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersUpdateFromRequest extends FormRequest
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
            'last_name' => 'string|max:20',
            'first_name' => 'string|max:20',
            'email' => 'email',
            'password' => 'min:8|max:255',
            'image_url' => 'string',
            'status_comment' => 'string|max:255',
            'charity_id' => 'integer',
            'is_stylist' => 'boolean',
            'salon_name' => 'string|max:30',
            'salon_address' => 'string|max:100',
        ];
    }
}
