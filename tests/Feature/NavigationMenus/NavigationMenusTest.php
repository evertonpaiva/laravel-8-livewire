<?php

namespace Tests\Feature\NavigationMenus;

use App\Http\Livewire\NavigationMenus;
use App\Models\NavigationMenu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * @group navigationMenu
 */
class NavigationMenusTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /** @test */
    public function navigation_menu_page_contains_navigation_menu_component()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $this->get('/navigation-menus')
            ->assertSeeLivewire('navigation-menus');
    }

    /**
     * @test
     */
    public function canCreateNavigationMenu()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $navigationMenuFake = NavigationMenu::factory()->make();

        Livewire::test(NavigationMenus::class)
            ->set('sequence', $navigationMenuFake->sequence)
            ->set('type', $navigationMenuFake->type)
            ->set('label', $navigationMenuFake->label)
            ->set('slug', $navigationMenuFake->slug)
            ->set('icon', $navigationMenuFake->icon)
            ->set('permission', $navigationMenuFake->permission)
            ->call('create');

        $this->assertDatabaseHas('navigation_menus', $navigationMenuFake->getAttributes());
    }

    /**
     * @test
     */
    public function checkRequiredFieldsCreateNavigationMenus()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        Livewire::test(NavigationMenus::class)
            ->call('create')
            ->assertHasErrors([
                'label' => 'required',
                'slug' => 'required',
            ]);
    }
}
