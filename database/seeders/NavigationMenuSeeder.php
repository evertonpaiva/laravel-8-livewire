<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NavigationMenu;

class NavigationMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //dashboard
        NavigationMenu::create([
            'label' => 'Painel',
            'slug' => 'dashboard',
            'sequence' => '1',
            'type' => 'SidebarNav',
            'icon' => 'fas fa-home',
        ]);

        //users
        NavigationMenu::create([
            'label' => 'Usuários',
            'slug' => 'users',
            'sequence' => '2',
            'type' => 'SidebarNav',
            'icon' => 'fas fa-users',
        ]);

        //navigation-menus
        NavigationMenu::create([
            'label' => 'Menus de navegação',
            'slug' => 'navigation-menus',
            'sequence' => '3',
            'type' => 'SidebarNav',
            'icon' => 'fas fa-bars',
        ]);

        //user-permissions
        NavigationMenu::create([
            'label' => 'Permissões por perfil',
            'slug' => 'user-permissions',
            'sequence' => '4',
            'type' => 'SidebarNav',
            'icon' => 'fas fa-user-lock',
        ]);

        //logout
        NavigationMenu::create([
            'label' => 'Sair',
            'slug' => 'logout',
            'sequence' => '5',
            'type' => 'SidebarNav',
            'icon' => 'fas fa-sign-out-alt',
        ]);
    }
}
