<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CenterDeviceUpdateRequest extends BaseRequest
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
            'is_support_auto_service'=>'nullable|string',
            'is_active'=>'nullable|string',
            'number_of_devices'=>'required|numeric',
        ];
    }

}
