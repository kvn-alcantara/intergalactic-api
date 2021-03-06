<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePilotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|numeric|min:18|max:65',
            'credits' => 'sometimes|required|numeric',
            'certification' => 'required|numeric|digits:7',
        ];
    }
}
