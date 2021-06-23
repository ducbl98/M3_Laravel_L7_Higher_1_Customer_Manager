<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'email'=>['required','email:rfc,dns',Rule::unique('customers','email')->ignore($this->id)],
            'dob'=>'required|before:today',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "This field can't be empty",
            'email.required' => "This field can't be empty",
            'email.email'=>'Wrong Email Format',
            'email.unique' => "This email is exist",
            'dob.required' => "This field can't be empty",
            'dob.before' => 'Invalid date',
        ];
    }
}
