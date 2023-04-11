<?php

namespace App\Http\Requests;


use App\Enum\PackageStatusEnum;
use Illuminate\Validation\Rule;

class PackageStoreRequest extends BaseRequest
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
            'center_id'            => 'required|exists:centers,id',
            'name.*'                 => 'required',
            'name.en' => [
                Rule::unique('packages', 'name->en')->where(function ($query) {
                    return $query->where('name->en', $this->name['en']);
                })
            ],
            'name.ar' => [
                Rule::unique('packages', 'name->ar')->where(function ($query) {
                    return $query->where('name->ar', $this->name['ar']);
                })
            ],
            'num_nabadat'          => 'required|integer',
            'price'                => 'required|numeric',
            'start_date'           => 'required|date',
            'end_date'             => 'required|date',
            'image'                => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'status'               => 'required|integer',
            'discount_percentage'  => ['numeric',Rule::requiredIf($this->status == PackageStatusEnum::APPROVED)],
        ];
    }

    public function messages()
    {
        return [
            'name.*.string' => __('lang.name_should_be_string'),
            'name.*.required' => __('lang.name__should_be_required'),
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(),['status'=>PackageStatusEnum::UNDERACHIEVING]);
    }
}
