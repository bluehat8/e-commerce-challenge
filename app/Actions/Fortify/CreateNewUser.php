<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $adminSecretKey = env('ADMIN_SECRET_KEY');

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'role' => ['required', 'string', 'in:admin,cliente'],
            // 'admin_key' => ['required_if:role,admin', 'string'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Si el rol es 'admin', verificar la clave secreta
        if ($input['role'] === 'admin') {
            if (!isset($input['admin_key']) || $input['admin_key'] !== $adminSecretKey) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'admin_key' => ['La clave de administrador es incorrecta.'],
                ]);
            }
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $input['role']
        ]);
    }
}
