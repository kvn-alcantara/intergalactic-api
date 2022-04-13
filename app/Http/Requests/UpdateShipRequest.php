<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShipRequest extends FormRequest
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
            'pilot_id' => 'sometimes|required|numeric|exists:pilots,id',
            'fuel_capacity' => 'sometimes|required|numeric',
            'fuel_level' => 'sometimes|required|numeric',
            'weight_capacity' => 'sometimes|required|numeric',
        ];
    }
}
