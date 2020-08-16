<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReturnItemStoreRequest extends FormRequest
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
            'suplier_id' => 'required|numeric',
            'summary' => 'required|numeric|min:0',
            'note' => 'required|string',
            'items' => 'required|array',
            'items.*.id' => 'required|numeric',
            'items.*.qty' => 'required|numeric|min:0',
            'items.*.buy_price' => 'required|numeric|min:0',
            'items.*.sell_price' => 'required|numeric|min:0',
            'items.*.stock' => 'required|numeric|min:0'
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
            'suplier_id' => 'Supplier',
            'summary' => 'Total',
            'note' => 'Keterangan',
            'items' => 'Barang',
            'items.*.id' => 'ID Barang',
            'items.*.qty' => 'Qty Retur Barang',
            'items.*.buy_price' => 'Harga Beli Barang',
            'items.*.sell_price' => 'Harga Jual Barang',
            'items.*.stock' => 'Qty Stock Barang'
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
