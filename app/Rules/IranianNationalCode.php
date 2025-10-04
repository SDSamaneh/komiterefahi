<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IranianNationalCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\d{10}$/', $value)) {
            $fail('کد ملی باید ۱۰ رقم باشد.');
            return;
        }

        // الگوریتم صحت کد ملی
        $check = (int)substr($value, 9, 1);
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += ((int)substr($value, $i, 1)) * (10 - $i);
        }
        $mod = $sum % 11;

        if (!(($mod < 2 && $check == $mod) || ($mod >= 2 && $check == 11 - $mod))) {
            $fail('کد ملی نامعتبر است.');
        }
    }
}
