<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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

            'fname' => 'required',
            'sname' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'min:11|max:11|required|unique:users',
            'password' => 'min:6|required|confirmed',

        ];
    }

    public function messages()
    {
        return [
            'fname.required' => 'Firstname is required',
            'sname.required' => 'Surname is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email is already in use',
            'email.email' => 'Email is not valid',
            'phone_number.required' => 'Phone number is required',
            'phone_number.min' => 'Phone must not be less than 11 characters',
            'phone_number.max' => 'Phone must not be more thaan than 11 characters',
            'phone_number.unique' => 'Phone number already in use',
            'password.required' => 'Password is required',
            'password.min' => 'Password should be minimum of 6 characters',
            'password.confirmed' => 'Confirm password must match Password',
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
