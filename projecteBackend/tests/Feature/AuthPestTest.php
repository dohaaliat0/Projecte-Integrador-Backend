<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\postJson;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);
it('can login with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'terminationDate' => null,
    ]);

    $response = postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'message' => 'User signed in',
             ]);
});


it('cannot login with invalid credentials', function () {
    $response = postJson('/api/login', [
        'email' => 'wrong@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401)
             ->assertJson([
                 'success' => false,
                 'message' => 'Unauthorised.',
                 'info' => [
                     'error' => 'Incorrect Email/Password',
                 ],
             ]);
});

it('can redirect to google', function () {
    $response = get('/api/login/google');

    $response->assertStatus(302);
});

it('can handle google callback with existing user', function () {
    $user = User::factory()->create([
        'email' => 'admin@example.com',
    ]);

    mockSocialiteFacade($user);

    $response = get('/api/login/google/callback');

    $response->assertStatus(200)
             ->assertViewHas('token')
             ->assertViewHas('user');
});

function mockSocialiteFacade($user)
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
