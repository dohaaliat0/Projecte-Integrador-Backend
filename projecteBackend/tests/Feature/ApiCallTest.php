<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\postJson;
use function Pest\Laravel\delete;
use function Pest\Laravel\putJson;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('can list calls', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = get('/api/calls');

    $response->assertStatus(200);
});

it('can create a call', function () {
    Sanctum::actingAs(User::factory()->create());

    $callData = [
        'details' => 'Test call details',
        'dateTime' => now()->toDateTimeString(),
        'operatorId' => User::factory()->create()->id,
        'patientId' => \App\Models\Patient::factory()->create()->id,
        'incomingCall' => [
            'type' => "Health Emergencies",
            'emergencyLevel' => 3
        ]
    ];

    $response = postJson('/api/calls', $callData);

    $response->assertStatus(201);
});

it('can show a call', function () {
    Sanctum::actingAs(User::factory()->create());

    $call = \App\Models\Call::factory()->create();

    $response = get("/api/calls/{$call->id}");

    $response->assertStatus(200);
});

it('can update a call', function () {
    Sanctum::actingAs(User::factory()->create());

    $call = \App\Models\Call::factory()->create();

    $updateData = [
        'details' => 'Test call details',
        'dateTime' => now()->toDateTimeString(),
        'operatorId' => User::factory()->create()->id,
        'patientId' => \App\Models\Patient::factory()->create()->id,
        'incomingCall' => [
            'type' => "Health Emergencies",
            'emergencyLevel' => 3
        ]
    ];

    $response = putJson("/api/calls/{$call->id}", $updateData);

    $response->assertStatus(200);
});

it('can delete a call', function () {
    Sanctum::actingAs(User::factory()->create());

    $call = \App\Models\Call::factory()->create();

    $response = delete("/api/calls/{$call->id}");

    $response->assertStatus(200);
});