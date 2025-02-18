<?php

namespace App\Http\Requests;

use App\Models\User;
use Carbon\Carbon;

class RegisterRequest extends BaseRequest
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
            'name'=>'required|string',
            'phone'=>'required|string|unique:users,phone',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|confirmed|min:6',
            'date_of_birth'=>'nullable|date|before:'.Carbon::now()->setTimezone('Africa/Cairo')->format('Y-m-d'),
            'location_id'=>'nullable|integer|exists:locations,id',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['type'=>User::CUSTOMERTYPE , 'last_login_at' => now()]);
    }
//    todo trans all validation message
//    public function messages()
//    {
//       return[
//           'name.required'=>__(''),
//           'email.required'=>__(''),
//           'email.email'=>__(''),
//           'phone.required'=>__(''),
//           'phone.numeric'=>__(''),
//           'password.required'=>__(''),
//           'password.confirmed'=>__(''),
//           'password.min'=>__(''),
//           'date_of_birth.required'=>__(''),
//           'location_id.required'=>__(''),
//       ];
//    }
}
