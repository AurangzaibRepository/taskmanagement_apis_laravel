<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class PasswordRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::where('email', $attributes['email'])
            ->first();

        if (! Hash::check($attribute['password'], $user->password)) {
            $fail('Invalid credentials');
        }
    }
}
