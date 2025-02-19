<?php
namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => ['token', 'user']]);
    }

    public function test_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
                 ->assertJson(['error' => 'Unauthorised.']);
    }

    public function test_register_with_valid_data()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'confirm_password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => ['token', 'name']]);
    }

    public function test_register_with_invalid_data()
    {
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'password',
            'confirm_password' => 'differentpassword',
        ]);

        $response->assertStatus(422)
                 ->assertJsonStructure(['error' => ['name', 'email', 'confirm_password']]);
    }

    public function test_logout()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'User successfully signed out.']);
    }

    public function test_google_redirect()
    {
        $response = $this->get('/api/login/google');

        $response->assertStatus(302);
    }

    public function test_google_callback_with_existing_user()
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
        ]);

        $this->mockSocialiteFacade($user);

        $response = $this->get('/api/login/google/callback');

        $response->assertStatus(200)
                 ->assertViewHas('token')
                 ->assertViewHas('user');
    }

    private function mockSocialiteFacade($user)
    {
        $abstractUser = \Mockery::mock(\Laravel\Socialite\Contracts\User::class);
        $abstractUser->shouldReceive('getId')->andReturn('12345');
        $abstractUser->shouldReceive('getEmail')->andReturn($user->email);
        $abstractUser->shouldReceive('getAvatar')->andReturn('avatar_url');

        $provider = \Mockery::mock(\Laravel\Socialite\Contracts\Provider::class);
        $provider->shouldReceive('stateless')->andReturnSelf();
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);
    }
}
