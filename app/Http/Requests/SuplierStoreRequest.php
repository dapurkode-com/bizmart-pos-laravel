<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuplierStoreRequest extends FormRequest
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
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nama',
            'address' => 'alamat',
            'phone' => 'kontak',
            'description' => 'keterangan',
        ];
    }
}
