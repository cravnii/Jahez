<?php

namespace App\Http\Requests\Restaurants;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'min:3', 'max:50'],
            'phone_number' => ['nullable', new PhoneRule()],
            'email' => ['nullable', 'email', 'unique:users'],
            'location' => ['nullable', 'string', 'alpha'],
        ];
    }
}
