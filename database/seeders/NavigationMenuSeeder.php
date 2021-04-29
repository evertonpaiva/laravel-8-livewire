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
            'permission' => 'dashboard.list',
        ]);

        //importacoes
        NavigationMenu::create([
            'label' => 'Importações',
            'slug' => 'importacoes',
            'sequence' => '2',
            'type' => 'SidebarNav',
            'icon' => 'fas fa-download',
            'permission' => 'importacao.list',
        ]);

        //users
        NavigationMenu::create([
            'label' => 'Usuários',
            'slug' => 'users',
            'sequence' => '3',
            'type' => 'SidebarNav',
            'icon' => 'fas fa-user-friends',
            'permission' => 'user.list',
        ]);

        //navigation-menus
        NavigationMenu::create([
            'label' => 'Menus de navegação',
            'slug' => 'navigation-menus',
            'sequence' => '4',
            'type' => 'SidebarNav',
            'icon' => 'fas fa-bars',
            'permission' => 'navigation-menu.list',
        ]);

        //user-permissions
        NavigationMenu::create([
            'label' => 'Permissões por perfil',
            'slug' => 'user-permissions',
            'sequence' => '5',
            'type' => 'SidebarNav',
            'icon' => 'fas fa-user-lock',
            'permission' => 'user-permission.list',
        ]);

        //pessoas
        NavigationMenu::create([
            'label' => 'Pessoas',
            'slug' => 'pessoas',
            'sequence' => '6',
            'type' => 'SidebarNav',
            'icon' => 'fas fa-users',
            'permission' => 'pessoa.list',
        ]);

        //cursor
        NavigationMenu::create([
            'label' => 'Cursos',
            'slug' => 'cursos',
            'sequence' => '7',
            'type' => 'SidebarNav',
            'icon' => 'fas fa-graduation-cap',
            'permission' => 'curso.list',
        ]);

        //logout
        NavigationMenu::create([
            'label' => 'Sair',
            'slug' => 'logout',
            'sequence' => '8',
            'type' => 'SidebarNav',
            'icon' => 'fas fa-sign-out-alt',
            'permission' => 'logout.do',
        ]);
    }
}
