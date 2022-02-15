<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam telephone string required The customer phone number.
 * @bodyParam first_name string required  The customer first name. Example: John
 * @bodyParam last_name string required  The customer last name. Example: Doe
 * @bodyParam add_street string required  The customer Address. Example: 48 Ogunaike street, Ikoyi, Lagos State.
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
            'first_name' => ['sometimes', 'required', 'string', 'max:2555'],
            'last_name' => ['sometimes', 'required', 'string', 'max:2555'],
            'telephone' => ['sometimes', 'required', 'string', 'min:11'],
            'add_street' => ['sometimes', 'required', 'string']
        ];
    }
}
