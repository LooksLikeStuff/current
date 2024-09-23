<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnoughBalance implements ValidationRule
{
    public function __construct($quantity, $price, $commission)
    {
        if (is_null($quantity) || is_null($price) || is_null($commission)) {
            $this->price = null;
        } else {
            $this->price = $price * $quantity - $commission;
        }

    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($this->price)) $fail('Заполните все поля');

        if ($value < $this->price) $fail('Недостаточно средств на балансе (Баланс: ' . $value . '₽' . ' Покупка: ' . $this->price . '₽' . ')');
    }
}
