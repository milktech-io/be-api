<?php

namespace App\Http\Requests\ModuleController;

use Illuminate\Foundation\Http\FormRequest;

class RangueRequest extends FormRequest
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
            'rangue' => 'string',
            'rangue_number' => 'numeric',
            'role' => 'required|string',
        ];
    }
}
