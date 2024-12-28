<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Certificate;

class UniqueFirstFourDigits implements Rule
{
    public function passes($attribute, $value)
    {
        // Extract the first 4 digits from the certificate number
        $firstFourDigits = substr($value, 0, 4);

        // Check if any certificate already exists with the same first 4 digits
        return !Certificate::where('certificate_no', 'LIKE', $firstFourDigits . '%')->exists();
    }

    public function message()
    {
        return 'The first 4 digits of the certificate number must be unique.';
    }
}
