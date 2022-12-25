<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;

class ReservationHistoryStoreRequest extends BaseRequest
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
            'status' => 'required|integer|in:2,3,4,5',
            'from'=>'required_if:status,==,'.Reservation::CONFIRMED,
            'to'=>'required_if:status,==,'.Reservation::CONFIRMED,
        ];
    }

    public function messages()
    {
        return[
            'required_if' => 'The :attribute field is required when :other is Confirmed.',
        ]; // TODO: Change the autogenerated stub
    }
}
