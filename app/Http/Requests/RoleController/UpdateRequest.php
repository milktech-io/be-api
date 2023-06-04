<?php

namespace App\Http\Requests\RoleController;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        $id = $this->route('role');

        return [
            'name' => [
                'required',
                'string',
                Rule::unique('roles', 'name')->ignore($id),
            ],
            'permissions.*' => 'string|exists:permissions,name',
        ];
    }
}
