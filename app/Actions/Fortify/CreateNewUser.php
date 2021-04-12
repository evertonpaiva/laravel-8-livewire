<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use GraphqlClient\GraphqlRequest\AuthGraphqlRequest;
use Illuminate\Validation\ValidationException;
use GraphqlClient\GraphqlRequest\Common\PessoaGraphqlRequest;

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

        $dados = $this->logarContaInstitucional($loginInfo);

        return User::create([
            'nome' => $dados['nome'],
            'email' => $input['email'],
            'containstitucional' => $input['containstitucional'],
            'cpf' => $dados['cpf'],
            'idpessoa' => $dados['idpessoa'],
            'password' => Hash::make(''),
        ]);
    }

    /**
     * Tenta realizar autenticação na Conta Institucional da UFVJM
     * Caso tenha sucesso, retorna alguma informações do usuário logado
     *
     * @param object $request
     * @return array
     * @throws ValidationException
     */
    private function logarContaInstitucional(object $request)
    {
        try {
            // Carrega a classe de autenticação
            $authGraphqlRequest = new AuthGraphqlRequest();

            // Tenta realizar o login na Conta Institucional
            $authGraphqlRequest->loginContaInstitucional($request);

            // Recupera as informações do usuário logado
            $userInfo = $authGraphqlRequest->usuarioLogadoInfo();

            $idpessoa = $userInfo->idpessoa;

            // Carrega a classe de pessoa
            $pessoaGraphqlRequest = new PessoaGraphqlRequest();

            // Recupera informações de pessoa por código
            $pessoa =
                $pessoaGraphqlRequest
                    ->queryGetById($idpessoa)
                    ->getResults();

            // Completa os dados de usuário, para cadastrá-lo
            $dados = [];
            $dados['nome'] = $userInfo->nome;
            $dados['cpf'] = $userInfo->cpf;
            $dados['idpessoa'] = $pessoa->idpessoa;

            return $dados;
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $this->sendFailedRegisterResponse($request, $errorMessage);
        }
    }

    /**
     * Trata as messagens de erro em caso de falha
     * @param object $request
     * @param String $message
     * @throws ValidationException
     */
    protected function sendFailedRegisterResponse(object $request, String $message)
    {
        throw ValidationException::withMessages([
            'containstitucional' => [$message],
        ]);
    }
}
