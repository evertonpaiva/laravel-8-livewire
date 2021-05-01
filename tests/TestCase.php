<?php

namespace Tests;

use App\Actions\Ufvjm\AuthContaInstitucional;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Realiza login na Integracao
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function loginIntegracao()
    {
        $loginInfo = new \stdClass();

        $loginInfo->containstitucional = env('LDAP_USERNAME');
        $loginInfo->password = env('LDAP_PASSWORD');

        $authContaInstitucional = new AuthContaInstitucional();
        $authContaInstitucional->logarContaInstitucional($loginInfo);
    }
}
