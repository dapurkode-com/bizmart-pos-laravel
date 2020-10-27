<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SellStoreRequest extends FormRequest
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
            'member_id' => 'required|numeric',
            'summary' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'note' => 'required|string',
            'paid_amount' => 'required|numeric',
            'sell_details' => 'required|array',
            'sell_details.*.item_id' => 'required|numeric',
            'sell_details.*.qty' => 'required|numeric|min:0',
            'sell_details.*.sell_price' => 'required|numeric|min:0',
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
            'member_id' => 'Member',
            'summary' => 'Total',
            'tax' => 'PPN',
            'note' => 'Keterangan',
            'paid_amount' => 'Nominal Bayar',
            'sell_details' => 'List Barang',
            'sell_details.*.item_id' => 'ID Barang',
            'sell_details.*.qty' => 'Qty Barang',
            'sell_details.*.sell_price' => 'Harga Jual',
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
