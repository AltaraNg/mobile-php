<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam phone_number string required The customer phone number.
 * @bodyParam regenerate boolean  Pass this to regenerate otp code for users if previous one has expired 
 */
class SendOtpRequest extends FormRequest
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
            'regenerate' => ['nullable', 'bool']
        ];
    }
}
