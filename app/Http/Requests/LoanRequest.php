<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
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
            'repayment' => ['required', 'numeric'],
            'repayment_cycle_id' => ['required', 'exists:repayment_cycles,id'],
            'down_payment' => ['required', 'numeric'],
            'loan_amount' => ['required', 'numeric', 'min:5000'],
            'documents' =>  ['sometimes', 'array', 'min:1'],
            'documents.*.url' => ['required', 'string'],
            'documents.*.name' => ['required', 'string'],
        ];
    }
}
