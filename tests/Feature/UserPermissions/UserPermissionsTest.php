<?php

namespace Tests\Feature\UserPermissions;

use App\Http\Livewire\UserPermissions;
use App\Models\UserPermission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * @group userPermission
 */
class UserPermissionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_permission_page_contains_user_permission_component()
    {
        $this->actingAs(User::factory(['role' => 'admin'])->create());

        $this->get('/user-permissions')
            ->assertSeeLivewire('user-permissions');
    }

    /**
     * @test
     */
    public function canCreateUserPermission()
    {
        $this->actingAs(User::factory()->create());

        $userPermissionFake = UserPermission::factory()->make();

        Livewire::test(UserPermissions::class)
            ->set('role', $userPermissionFake->role)
            ->set('routeName', $userPermissionFake->route_name)
            ->call('create');

        $this->assertDatabaseHas('user_permissions', $userPermissionFake->getAttributes());
    }

    /**
     * @test
     */
    public function checkRequiredFieldsCreateUserPermission()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(UserPermissions::class)
            ->call('create')
            ->assertHasErrors([
                'role' => 'required',
                'routeName' => 'required',
            ]);
    }
}
