<?php

namespace App\Http\Requests\Meals;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMealRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['c', 'integer'],
            'restaurant_id' => ['nullable', 'integer', 'exists:restaurants,id'],
            'name' => ['nullable', 'string'],
            'price' => ['nullable', 'integer'],
        ];
    }
}
