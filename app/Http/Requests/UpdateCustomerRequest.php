<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam telephone string required The customer phone number.
 * @bodyParam first_name string required  The customer first name. Example: John
 * @bodyParam last_name string required  The customer last name. Example: Doe
 * @bodyParam add_street string required  The customer Address. Example: 48 Ogunaike street, Ikoyi, Lagos State.
 * @bodyParam state string required The customer state.
 * @bodyParam city string required The customer city.
 * @bodyParam gender string required The customer gender Example: male
 * @bodyParam date_of_birth string required The customer date of birth. Example 
 */
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
            'first_name' => ['required', 'string', 'max:2555'],
            'last_name' => ['required',  'string', 'max:2555'],
            'add_street' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' =>  ['required', 'string'],
            'gender' =>  ['required', 'string'],
            'date_of_birth' =>  ['required', 'date'],
            'employment_status'=> ['required', 'string'],
            "civil_status" => ['required', 'string']
        ];
    }
}
