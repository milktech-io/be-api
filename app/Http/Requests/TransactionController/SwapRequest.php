<?php

namespace App\Http\Requests\TransactionController;

use Illuminate\Foundation\Http\FormRequest;

class SwapRequest extends FormRequest
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
        return[
            'quantity_from' => 'required',
            'currency_from' => 'required',
            'quantity_to' => 'required',
            'currency_to' => 'required',
            'transaction_hash' => 'required|unique:transactions,transaction_hash',
            'transaction_index' => 'required',
        ];
    }
}
