<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class PasswordCompareRule implements ValidationRule
{
    public function __construct($email)
    {
        $this->$email = $email;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
    }
}
