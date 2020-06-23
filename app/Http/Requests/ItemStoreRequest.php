<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
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
            'barcode'                => [
                'string',
                'min:4',
                'max:30',
                'required',
                Rule::unique('items', 'barcode')
                    ->where(function ($query) {
                        return $query->where('deleted_at', null);
                    }),
            ], //barcode
            'name'                   => 'required|string|max:255', // nama barang
            'description'            => 'string|nullable', // deskripsi barnag
            'is_stock_active'        => 'required|boolean', // status stok
            'stock'                  => 'required_if:is_stock_active,true|numeric|min:0', //jumlah stok barang
            'unit_id'                => 'required_if:is_stock_active,true|integer|exists:units,id',
            'min_stock'              => 'numeric|min:0|nullable', // stok minimal
            'buy_price'              => 'required|numeric|min:0', // harga beli
            'sell_price_determinant' => 'required|numeric', // penentu harga jual
            'sell_price'             => 'required_if:sell_price_determinant,0|numeric|nullable', // harga jual
            'margin'                 => 'required_if:sell_price_determinant,1|numeric|nullable', // margin harga
            'markup'                 => 'required_if:sell_price_determinant,2|numeric|nullable', // markup harga
            'profit'                 => 'required_if:sell_price_determinant,3|numeric|nullable', // jumlah keuntungan
            'categories'             => 'nullable|string', // kategori barang
        ];
    }
}
