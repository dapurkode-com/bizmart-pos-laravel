<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|unique:users|email',
            'username' => 'required|unique:users|string',
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'nama',
        ];
    }

    /**
     * Get custom fail response
     * 
     * @return array
     */
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()
            ->json([
                'status' => 'invalid',
                'validators' => $validator->errors(),
            ])); 
    }
}
