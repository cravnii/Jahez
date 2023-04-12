<?php

namespace App\Http\Requests\Users;

use App\Enums\GenderEnum;
use App\Rules\PhoneRule;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => ['nullable', 'email', 'unique:users'],
            'gender' => ['nullable', 'integer', new EnumValue(GenderEnum::class,false)],
            'password' => ['nullable', 'string', 'min:8', 'regex:/^[a-zA-Z0-9$#@!%^&*()\-_=+{};:,<.>\/?|[\]~`]+$/'],
            'phone_number' => ['nullable', new PhoneRule()]
        ];
    }



}
