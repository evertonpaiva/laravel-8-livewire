<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            NavigationMenuSeeder::class,
            RoleTableSeeder::class,
            PermissionTableSeeder::class,
            RolePermissionsTableSeeder::class,
        ]);
    }

    /**
     * Criando usuarios e atribuindo um perfil aleatoria e eles
     * @throws \Exception
     */
    private function createFakeUsers()
    {
        // numero de usuarios
        $newUsers = 100;

        // loop para criar usuarios
        for($i = 0; $i < $newUsers; $i++){
            // criando um usuario
            $user = \App\Models\User::factory(1)->create()->first();

            // numero de perfis - 1, ajuste pois o vetor se inicia em 0
            $numberOfRoles = count(User::userRoleList()) - 1;

            // escolher aleatoriamente um indice para o vetor de nome de perfis
            $randomInt = random_int(0, $numberOfRoles);
            $roleName = User::userRoleList()[$randomInt];

            // atribuindo um perfil para o usuario criado
            $user->assignRole($roleName);
        }
    }
}
