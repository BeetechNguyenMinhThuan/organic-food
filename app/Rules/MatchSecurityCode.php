<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchSecurityCode implements ValidationRule
{
    private mixed $generatedCode;

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function __construct($generatedCode)
    {
        $this->generatedCode = $generatedCode;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!($value == $this->generatedCode)) {
            $fail('Mã security code không chính xác');
        }
    }
}
