<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolePermissions = [];

        // Adiciona todas as permissoes para o admin
        $rolePermissions['Admin'] = Permission::pluck('name')->toArray();

        // Permissoes para perfil Usuario
        $rolePermissions['Usuário'] = [
            0 => 'dashboard.list',
            1 => 'navigation-menu.list',
            2 => 'logout.do',
        ];

        foreach ($rolePermissions as $key => $value) {
            $roleName = $key;
            $permsArray = $value;

            // Percorre o vetor de permissoes
            foreach($permsArray as $permission) {
                $role = Role::findByName($roleName);
                $role->givePermissionTo($permission);
            }
        }
    }
}
