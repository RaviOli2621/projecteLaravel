<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordService
{
    /**
     * Encripta una contraseña usando Hash de Laravel
     *
     * @param string $password
     * @return string
     */
    public static function encrypt(string $password): string
    {
        return Hash::make($password); // Cifra la contraseña
    }

    /**
     * Verifica si una contraseña coincide con la contraseña cifrada
     *
     * @param string $password
     * @param string|null $hashedPassword
     * @return bool
     * @throws ValidationException
     */
    public static function verify(string $password, ?string $hashedPassword): bool
    {
        if (empty($hashedPassword)) {
            throw ValidationException::withMessages([
                'authentication' => 'Només et pots logar per social authentication', // Mensaje personalizado
            ]);
        }

        return Hash::check($password, $hashedPassword); // Compara la contraseña con la versión cifrada
    }
}
