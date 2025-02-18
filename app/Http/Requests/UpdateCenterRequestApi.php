<?php

namespace App\Http\Requests;

use App\Enum\PaymentMethodEnum;

class UpdateCenterRequestApi extends BaseRequest
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
            'name' => 'required|array',
            'name.*' => 'required|string',
            'user_name' => 'required|string',
            'phones' => 'nullable|array',
            'phones.*' => 'nullable|string',
            'location_id' => 'required|integer',
            'primary_phone' => 'required|string|unique:users,phone,' . $this->user_id,
            'lat' => 'nullable|string',
            'lng' => 'nullable|string',
            'address' => 'required|array',
            'address.*' => 'string|required',
            'description' => 'nullable|array',
            'description.*' => 'string',
            'password' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'is_active' => 'nullable|string',
            'is_support_auto_service' => 'string|nullable',
            'avg_waiting_time' => 'required',
            'support_payments' => 'required|array|min:1',
            'support_payments.*' => 'string|in:' . PaymentMethodEnum::CREDIT . ',' . PaymentMethodEnum::CASH,
            'pulse_price' => 'required|numeric',
            'google_map_url' => 'string|nullable',
        ];
    }
    public function prepareForValidation()
    {
        $this->merge(['user_id'=>auth('sanctum')->id()]);
    }
}
