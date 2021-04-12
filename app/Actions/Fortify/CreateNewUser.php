<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Actions\Ufvjm\AuthContaInstitucional;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'containstitucional' => ['required', 'unique:users'],
            'password' => ['required'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $loginInfo = new \stdClass();
        $loginInfo->containstitucional = $input['containstitucional'];
        $loginInfo->password = $input['password'];

        $authContaInstitucional = new AuthContaInstitucional();
        $dados = $authContaInstitucional->logarContaInstitucional($loginInfo);

        return User::create([
            'nome' => $dados['nome'],
            'email' => $input['email'],
            'containstitucional' => $input['containstitucional'],
            'cpf' => $dados['cpf'],
            'idpessoa' => $dados['idpessoa'],
            'password' => Hash::make(''),
        ]);
    }
}
