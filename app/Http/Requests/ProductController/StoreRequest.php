<?php

namespace App\Http\Requests\ProductController;

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
            'slug' => 'required|string',
            'content' => 'required',
            'description' => 'nullable',
            'short_description' => 'nullable',
            'sold' => 'nullable',
            'variant' => 'required',
            'category_id' => 'required|exists:categories,id',
            'multiplier' => 'required',
            'static' => 'nullable',
            'features' => 'nullable',
            'metadata' => 'nullable',
        ];
    }
}
