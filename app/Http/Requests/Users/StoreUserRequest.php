<?php

namespace App\Http\Requests\Users;

use App\Enums\GenderEnum;
use App\Rules\PhoneRule;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'email', 'unique:users'],
            'gender' => ['required','integer', new EnumValue(GenderEnum::class,false)],
            'password' => ['required', 'string', 'min:8'],
            'phone_number' => ['required', new PhoneRule()]
        ];
    }
}
