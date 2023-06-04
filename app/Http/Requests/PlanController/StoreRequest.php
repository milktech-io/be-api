<?php

namespace App\Http\Requests\PlanController;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
            'currency' => 'required|string',
            'interest' => ['required', 'numeric'],
            'automatically_ends' => ['required', 'numeric'],
            'product_id' => 'required|exists:products,id',
            'image' => 'required|image',
        ];
    }
}
