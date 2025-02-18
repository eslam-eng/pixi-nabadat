<?php

namespace App\Http\Requests;

use App\Enum\PaymentMethodEnum;
use App\Models\Center;
use Illuminate\Validation\Rule;

class UpdateCenterRequest extends BaseRequest
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
        $userId = Center::find($this->center)->user->id;
        return [

            'name'                   => 'required|array',
            'name.*'                 => 'required|string',
            // 'user_name'                 => 'required|string',
            'phones'                 => 'nullable|array',
            'phones.*'               => 'nullable|string',
            'location_id'            => 'required|integer',
            'primary_phone'          => 'required|numeric|unique:users,phone,'.$userId,
            'lat'                    => 'nullable|string',
            'lng'                    => 'nullable|string',
            'address'                => 'required|array',
            'address.*'              => 'string|required',
            'description'            => 'required|array',
            'description.*'           => 'string|nullable',
            'images'                  => 'nullable|array',
            'logo'                    => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'profile_image'           => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'images.*'                => 'image|mimes:jpg,png,jpeg,gif,svg',
            'password'                => 'nullable|string',
            'email'                   =>['required',Rule::unique('users','email')->ignore($this->center,'center_id')] ,
            'is_active'               => 'nullable|string',
            'is_support_auto_service' => 'string|nullable',
            'avg_waiting_time'         => 'required',
            'featured'                => 'nullable|string',
            'support_payments'        => 'array|min:1',
            'support_payments.*'      => 'string|in:'.PaymentMethodEnum::CREDIT.','.PaymentMethodEnum::CASH,
            'pulse_price'             => 'required|numeric',
            'pulse_discount'          => 'required|numeric',
            'app_discount'            => 'required|numeric',
            'google_map_url'          => 'string|nullable',
            'status'                  => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'phone.*.string' => __('lang.phone_en_should_be_string'),
            'name.*.required' => __('lang.title_in_ar_should_be_required'),
            'location_id.required' => __('lang.location_should_be_required'),
        ];
    }
}
