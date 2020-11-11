<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BuyPaymentHsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric',
            'note' => 'nullable|string',
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
            'amount' => 'Nominal Tagihan',
            'note' => 'Keterangan',
        ];
    }

    /**
     * Get custom fail response
     * 
     * @return array
     */
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json([
                'status' => 'invalid',
                'validators' => $validator->errors(),
            ])
        );
    }
}
