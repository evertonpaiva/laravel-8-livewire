<?php

namespace Tests\Feature\NavigationMenus;

use App\Http\Livewire\NavigationMenus;
use App\Models\NavigationMenu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Arr;

/**
 * @group navigationMenu
 */
class NavigationMenusTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function testNavigationMenuPageContainsNavigationMenuComponent()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $this->get('/navigation-menus')
            ->assertSeeLivewire('navigation-menus');
    }

    public function testCanCreateNavigationMenu()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $navigationMenuFake = NavigationMenu::factory()->make();

        Livewire::test(NavigationMenus::class)
            ->call('createShowModal')
            ->set('sequence', $navigationMenuFake->sequence)
            ->set('type', $navigationMenuFake->type)
            ->set('label', $navigationMenuFake->label)
            ->set('slug', $navigationMenuFake->slug)
            ->set('icon', $navigationMenuFake->icon)
            ->set('permission', $navigationMenuFake->permission)
            ->call('create');

        $this->assertDatabaseHas('navigation_menus', $navigationMenuFake->getAttributes());
    }

    public function testCheckRequiredFieldsCreateNavigationMenus()
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

    public function testNavigationMenuInformationCanBeUpdated()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $navigationMenu = NavigationMenu::factory()->create()->first();

        $navigationMenu->label = 'Test label';
        $navigationMenu->slug = 'test-slug';
        $navigationMenu->sequence = '100';
        $navigationMenu->type = 'TopNav';
        $navigationMenu->icon = 'fas test';
        $navigationMenu->permission = 'test.list';

        Livewire::test(NavigationMenus::class)
            ->call('updateShowModal', $navigationMenu->id)
            ->set('label', $navigationMenu->label)
            ->set('slug', $navigationMenu->slug)
            ->set('sequence', $navigationMenu->sequence)
            ->set('type', $navigationMenu->type)
            ->set('icon', $navigationMenu->icon)
            ->set('permission', $navigationMenu->permission)
            ->call('update');

        $this->assertDatabaseHas(
            'navigation_menus',
            Arr::except($navigationMenu->getAttributes(), ['updated_at'])
        );
    }

    public function testNavigationMenuCanBeDeleted()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $navigationMenu = NavigationMenu::factory()->create()->first();

        $component = Livewire::test(NavigationMenus::class)
            ->call('deleteShowModal', $navigationMenu->id)
            ->call('delete');

        $this->assertDatabaseMissing('navigation_menus', $navigationMenu->getAttributes());
    }
}
