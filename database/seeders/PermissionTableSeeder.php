<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'dashboard.list',

            'importacao.list',
            'importacao.create',

            'user.list',
            'user.create',
            'user.edit',
            'user.delete',

            'role.list',
            'role.create',
            'role.edit',
            'role.delete',

            'navigation-menu.list',
            'navigation-menu.create',
            'navigation-menu.edit',
            'navigation-menu.delete',

            'pessoa.list',

            'curso.list',

            'logout.do',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
