<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;
use Tests\TestCase;
use App\Http\Livewire\DeleteProfile;

/**
 * @group auth
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function testHomeLoginScreeCanBeRendered()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testLoginScreenCanBeRendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testUsersCanAuthenticateUsingTheLoginScreen()
    {
        $username = env('LDAP_USERNAME');
        $password = env('LDAP_PASSWORD');

        $user = User::factory(['containstitucional' => $username])->create()->first();
        $user->assignRole('Admin');

        $response = $this->post('/login', [
            'containstitucional' => $username,
            'password' => $password,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testUsersCanNotAuthenticateWithInvalidPassword()
    {
        $user = User::factory()->create()->first();

        $this->post('/login', [
            'containstitucional' => $user->containstitucional,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function testRegistrationScreenCanBeRendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testNewUsersCanRegister()
    {
        $username = env('LDAP_USERNAME');
        $password = env('LDAP_PASSWORD');

        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'containstitucional' => $username,
            'password' => $password
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testCurrentProfileInformationIsAvailable()
    {
        $this->actingAs($user = User::factory()->create());

        $component = Livewire::test(UpdateProfileInformationForm::class);

        $this->assertEquals($user->nome, $component->state['nome']);
        $this->assertEquals($user->email, $component->state['email']);
    }

    public function testProfileInformationCanBeUpdated()
    {
        $this->actingAs($user = User::factory()->create());

        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', ['nome' => 'Test Name', 'email' => 'test@example.com'])
            ->call('updateProfileInformation');

        $this->assertEquals('Test Name', $user->fresh()->nome);
        $this->assertEquals('test@example.com', $user->fresh()->email);
    }

    public function testUserCanDeleteYourProfile()
    {
        $username = env('LDAP_USERNAME');
        $password = env('LDAP_PASSWORD');

        $user = User::factory(['containstitucional' => $username])->create();
        $user->first()->assignRole('Usuário');
        $this->actingAs($user);

        $request = new Request();

        $response = Livewire::test(DeleteProfile::class)
            ->call('confirmUserDeletion')
            ->set('password', $password)
            ->call('deleteUser', $request, $user, auth());

        $this->assertGuest();
        $this->assertDatabaseMissing('users', $user->getAttributes());
        $response->assertRedirect(env('APP_URL'));
    }

    public function testUserCanNotDeleteYourProfileWithWrongPassword()
    {
        $username = env('LDAP_USERNAME');
        $password = 'wrong-pass';

        $user = User::factory(['containstitucional' => $username])->create();
        $user->first()->assignRole('Usuário');
        $this->actingAs($user);

        $request = new Request();

        Livewire::test(DeleteProfile::class)
            ->call('confirmUserDeletion')
            ->set('password', $password)
            ->call('deleteUser', $request, $user, auth())
            ->assertHasErrors(['password']);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', $user->getAttributes());
    }
}
