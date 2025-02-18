<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends BaseRequest
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
            'email' => 'required|email|unique:users,email,'.$this->client,
            'phone' => 'required|string|unique:users,phone,'.$this->client,
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'password' => 'sometimes|nullable|string|max:255',
            'is_active' => 'nullable',
            'location_id' => 'required|integer|exists:locations,id',
            'date_of_birth'=>'nullable|date|before:'.Carbon::now()->setTimezone('Africa/Cairo')->format('Y-m-d'),
        ];
    }

}
