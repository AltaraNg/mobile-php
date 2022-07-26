<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

/**
 * @bodyParam phone_number string required The customer phone number.
 * @bodyParam otp string required The otp sent to the customer phone number
 * @bodyParam device_name required The customer device name been used
 */
class LoginRequest extends FormRequest
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
            'phone_number' => ['required', 'string'],
            'otp' => [new RequiredIf($this->login_type == 'otp'), 'string', 'min:4'],
            'password' => [new RequiredIf($this->login_type == 'password'), 'string'],
            'device_name' => ['required', 'string'],
            'login_type' => ['required', 'string', Rule::in(['otp', 'password'])]
        ];
    }
}
