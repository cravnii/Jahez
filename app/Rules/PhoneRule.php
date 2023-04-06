<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\Rule;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;

class PhoneRule implements Rule
{
    public function passes($attribute, $value)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        $countryCode = 'SA';
        try {
            $parsedPhoneNumber = $phoneUtil->parse($value, $countryCode);
            return $phoneUtil->isValidNumber($parsedPhoneNumber);
        } catch (NumberParseException $e) {
            return false;
        }
    }

    public function message()
    {
        return 'Invalid phone number.';
    }
}
