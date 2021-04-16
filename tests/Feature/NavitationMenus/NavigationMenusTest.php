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

    /** @test */
    public function navigation_menu_page_contains_navigation_menu_component()
    {
        $this->actingAs($user = User::factory(['role' => 'admin'])->create());

        $this->get('/navigation-menus')
            ->assertSeeLivewire('navigation-menus');
    }

    /**
     * @test
     */
    public function canCreateNavigationMenu()
    {
        $this->actingAs($user = User::factory()->create());

        $navigationMenuFake = NavigationMenu::factory()->make();

        Livewire::test(NavigationMenus::class)
            ->set('sequence', $navigationMenuFake->sequence)
            ->set('type', $navigationMenuFake->type)
            ->set('label', $navigationMenuFake->label)
            ->set('slug', $navigationMenuFake->slug)
            ->call('create');

        $this->assertDatabaseHas('navigation_menus', $navigationMenuFake->getAttributes());
    }

    /**
     * @test
     */
    public function checkRequiredFieldsCreateNavigationMenus()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(NavigationMenus::class)
            ->call('create')
            ->assertHasErrors([
                'label' => 'required',
                'slug' => 'required',
            ]);
    }
}
