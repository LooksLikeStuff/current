<?php

namespace App\Rules;

use Closure;
use App\Enums\Period as PeriodEnum;
use Illuminate\Contracts\Validation\ValidationRule;

class Period implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! in_array($value, PeriodEnum::getCaseNames())) {
            $fail('The period doesnt exist');
        }
    }
}
