<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->randomUsers();
    }

    /**
     * Cria 1000 usuários com perfils aleatórios
     * @throws \Exception
     */
    public function randomUsers()
    {
        // numero de usuarios
        $newUsers = 1000;

        // loop para criar usuarios
        for($i = 0; $i < $newUsers; $i++){
            // criando um usuario
            $user = User::factory(1)->create()->first();

            $numberOfRoles = count(User::userRoleList());
            $roleArray = User::userRoleList();

            $roleList = [];

            foreach($roleArray as $key => $value) {
                $roleList[] = $key;
            }

            // escolher aleatoriamente um indice para o vetor de nome de perfis
            $randomInt = random_int(0, ($numberOfRoles -1));
            $roleName = $roleList[$randomInt];

            // atribuindo um perfil para o usuario criado
            $user->assignRole($roleName);
        }
    }
}
