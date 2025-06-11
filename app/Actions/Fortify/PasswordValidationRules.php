<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function passwordRules(): array
   {
        // Menggunakan objek Password untuk aturan yang lebih modern dan aman
        return [
            'required',      // Password wajib diisi
            'string',        // Harus berupa string
            Password::min(8) // Minimal 8 karakter
                ->letters()      // Wajib mengandung setidaknya satu huruf
                ->mixedCase()    // Wajib mengandung huruf besar dan kecil
                ->numbers()      // Wajib mengandung setidaknya satu angka
                ->symbols()      // Wajib mengandung setidaknya satu simbol (cth: !@#$%^)
                ->uncompromised(), // Wajib belum pernah bocor di internet
            'confirmed'      // Wajib cocok dengan field konfirmasi password (password_confirmation)
        ];
    }
}
