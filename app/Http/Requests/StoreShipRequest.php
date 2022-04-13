<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShipRequest extends FormRequest
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
            'pilot_id' => 'required|numeric|exists:pilots,id',
            'fuel_capacity' => 'required|numeric',
            'fuel_level' => 'required|numeric',
            'weight_capacity' => 'required|numeric',
        ];
    }
}
