<?php

namespace App\Actions\Ufvjm;

use GraphqlClient\GraphqlRequest\AuthGraphqlRequest;
use GraphqlClient\GraphqlRequest\Common\PessoaGraphqlRequest;
use Illuminate\Validation\ValidationException;

class AuthContaInstitucional
{
    /**
     * Tenta realizar autenticação na Conta Institucional da UFVJM
     * Caso tenha sucesso, retorna alguma informações do usuário logado
     *
     * @param object $request
     * @return array
     * @throws ValidationException
     */
    public function logarContaInstitucional(object $request)
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
