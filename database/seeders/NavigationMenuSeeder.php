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
            'label' => 'dashboard',
            'slug' => 'dashboard',
            'sequence' => '1',
            'type' => 'TopNav',
        ]);

        //users
        NavigationMenu::create([
            'label' => 'users',
            'slug' => 'users',
            'sequence' => '2',
            'type' => 'TopNav',
        ]);

        //navigation-menus
        NavigationMenu::create([
            'label' => 'navigation-menus',
            'slug' => 'navigation-menus',
            'sequence' => '3',
            'type' => 'TopNav',
        ]);

        //user-permissions
        NavigationMenu::create([
            'label' => 'user-permissions',
            'slug' => 'user-permissions',
            'sequence' => '4',
            'type' => 'TopNav',
        ]);
    }
}
