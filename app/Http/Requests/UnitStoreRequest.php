<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitStoreRequest extends FormRequest
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
            'name' => 'required|string|unique:units,name,NULL,deleted_at',
            'description' => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nama',
            'description' => 'keterangan',
        ];
    }
}
