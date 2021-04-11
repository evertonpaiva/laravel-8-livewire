<?php

namespace Database\Seeders;

use App\Models\UserPermission;
use Illuminate\Database\Seeder;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserPermission::create([
            'role' => 'admin',
            'route_name' => 'dashboard',
        ]);

        UserPermission::create([
            'role' => 'admin',
            'route_name' => 'users',
        ]);

        UserPermission::create([
            'role' => 'admin',
            'route_name' => 'navigation-menus',
        ]);

        UserPermission::create([
            'role' => 'admin',
            'route_name' => 'user-permissions',
        ]);

        UserPermission::create([
            'role' => 'user',
            'route_name' => 'dashboard',
        ]);
    }
}
