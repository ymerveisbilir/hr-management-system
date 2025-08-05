<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
         // Minimum 8 karakter kontrolü
         if (strlen($value) < 8) {
            $fail('Şifre en az 8 karakter uzunluğunda olmalıdır.');
            return;
        }

        // En az bir küçük harf kontrolü
        if (!preg_match('/[a-z]/', $value)) {
            $fail('Şifre en az bir küçük harf içermelidir.');
            return;
        }

        // En az bir sayı, sembol veya boşluk kontrolü
        if (!preg_match('/[\d\s\W]/', $value)) {
            $fail('Şifre en az bir sayı, sembol veya boşluk içermelidir.');
            return;
        }
    }
}
