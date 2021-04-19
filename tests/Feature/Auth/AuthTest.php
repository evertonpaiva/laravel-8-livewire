<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * @group auth
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * @test
     */
    public function home_login_scree_can_be_rendered()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * @test
     * @medium
     */
    public function test_users_can_authenticate_using_the_login_screen()
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

    /**
     * @test
     */
    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'containstitucional' => $user->containstitucional,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /**
     * @test
     */
    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_new_users_can_register()
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

    /**
     * @test
     */
    public function test_current_profile_information_is_available()
    {
        $this->actingAs($user = User::factory()->create());

        $component = Livewire::test(UpdateProfileInformationForm::class);

        $this->assertEquals($user->nome, $component->state['nome']);
        $this->assertEquals($user->email, $component->state['email']);
    }

    /**
     * @test
     */
    public function test_profile_information_can_be_updated()
    {
        $this->actingAs($user = User::factory()->create());

        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', ['nome' => 'Test Name', 'email' => 'test@example.com'])
            ->call('updateProfileInformation');

        $this->assertEquals('Test Name', $user->fresh()->nome);
        $this->assertEquals('test@example.com', $user->fresh()->email);
    }
}
