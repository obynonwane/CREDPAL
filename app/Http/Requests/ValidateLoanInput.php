<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ValidateLoanInput extends FormRequest
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

    public function rules()
    {

        return [
            'amount' => 'required|numeric',
            'tenure' => 'required|numeric',
            'repayment_day' => 'required|numeric',
            'interest' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount is a numeric input',
            'tenure.required' => 'Tenure is required',
            'tenure.numeric' => 'Tenure is a numeric',
            'repayment_day.required' => 'Repayment date is required',
            'repayment_day.numeric' => 'Repayment date is a numeric input',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "status" => false,
            "message" => $validator->errors()->first()
        ], 400));
    }
}
