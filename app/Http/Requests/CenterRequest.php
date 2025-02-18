<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CenterRequest extends BaseRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'address' => 'string|required',
            'lat' => 'nullable|string',
            'lng' => 'nullable|string',
            'phones' => 'array|min:1|required',
            'location_id' => 'required|exists:locations,id',
        ];
    }
}
