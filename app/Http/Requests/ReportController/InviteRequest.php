<?php

namespace App\Http\Requests\ReportController;

use Illuminate\Foundation\Http\FormRequest;

class InviteRequest extends FormRequest
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
            'order' => 'nullable',
            'minDate' => 'nullable|date',
            'maxDate' => 'nullable|date',
            'limit' => 'nullable|numeric',
            'role_id' => 'nullable|exists:roles,id',
            'user_id' => 'nullable|exists:users,id',
            'rangue_id' => 'nullable|exists:rangues,id',
        ];
    }
}
