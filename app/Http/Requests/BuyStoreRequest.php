<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyStoreRequest extends FormRequest
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
            'buy_price.*'   => 'required|numeric|min:1',
            'qty.*'         => 'required|numeric|min:1',
            'supplier_id'    => 'required',
            'note'          => 'nullable|string',
        ];
    }
    public function attributes()
    {
        return [
            'buy_price.*'   => 'harga pembelian',
            'qty.*'         => 'kuantitas',
            'supplier_id'    => 'supplier',
            'note'          => 'keterangan',
        ];
    }
}
