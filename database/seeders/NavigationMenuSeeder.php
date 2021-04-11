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
        NavigationMenu::create([
            'label' => 'dashboard',
            'slug' => 'dashboard',
            'sequence' => '1',
            'type' => 'TopNav',
        ]);

        NavigationMenu::create([
            'label' => 'users',
            'slug' => 'users',
            'sequence' => '2',
            'type' => 'TopNav',
        ]);
    }
}
