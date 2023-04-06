<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'email', 'unique:users'],
            'gender' => ['required'],
            'password' => ['required', 'string', 'min:8', 'regex:/^[a-zA-Z0-9$#@!%^&*()\-_=+{};:,<.>\/?|[\]~`]+$/'],
            'phone_number' => ['required', function ($attribute, $value, $fail) {
                $phoneUtil = PhoneNumberUtil::getInstance();
                $countryCode = 'SA';
                try {
                    $parsedPhoneNumber = $phoneUtil->parse($value, $countryCode);
                    if (!$phoneUtil->isValidNumber($parsedPhoneNumber)) {
                        $fail('Invalid phone number.');
                    }
                } catch (NumberParseException $e) {
                    $fail('Invalid phone number.');
                }
            }],
        ];
    }
}
