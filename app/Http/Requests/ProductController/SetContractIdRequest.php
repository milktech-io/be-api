<?php

namespace App\Http\Requests\ProductController;

use Illuminate\Foundation\Http\FormRequest;

class SetContractIdRequest extends FormRequest
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
            'contract_id' => 'numeric|required',
            'variant' => 'required|string',
            'id' => 'required',
        ];
    }
}
