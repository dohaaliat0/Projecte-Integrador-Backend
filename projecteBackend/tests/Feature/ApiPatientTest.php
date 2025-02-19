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
it('can list patients', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = get('/api/patients');

    $response->assertStatus(200);
});

it('can create a patient', function () {
    Sanctum::actingAs(User::factory()->create());

    $patientData = [
        'fullName' => 'John Doe',
        'birthDate' => '1980-01-01',
        'fullAddress' => '123 Main St, Anytown, USA',
        'dni' => '12345678A',
        'healthCardNumber' => 'HC123456',
        'phone' => '123-456-7890',
        'email' => 'john.doe@example.com',
        'zoneId' => \App\Models\Zone::factory()->create()->id,
        'personalFamilySituation' => 'Single',
        'healthSituation' => 'Good',
        'housingSituation' => 'Own house',
        'personalAutonomy' => 'Independent',
        'economicSituation' => 'Stable',
        'operatorId' => User::factory()->create()->id,
        'languages' => ['Catalan', 'English'],
        'status' => 'Admitted',
        'contactPersons' => [
            [
                'firstName' => 'Jane',
                'lastName' => 'Doe',
                'phone' => '987654321',
                'relationship' => 'sibling'
            ]
        ]
    ];

    $response = postJson('/api/patients', $patientData);
    $response->assertStatus(201);
});

it('can show a patient', function () {
    Sanctum::actingAs(User::factory()->create());

    $patient = \App\Models\Patient::factory()->create();

    $response = get("/api/patients/{$patient->id}");

    $response->assertStatus(200);
});

it('can update a patient', function () {
    Sanctum::actingAs(User::factory()->create());

    $patient = \App\Models\Patient::factory()->create();

    $updateData = [
        'fullName' => 'John Doe Updated',
        'birthDate' => '1990-01-01',
        'fullAddress' => '123 Main St, Anytown, USA Updated',
        'dni' => '12345678A',
        'healthCardNumber' => 'HC123456',
        'phone' => '123-456-7890',
        'email' => 'john.doe.updated@example.com',
        'zoneId' => \App\Models\Zone::factory()->create()->id,
        'personalFamilySituation' => 'Single',
        'healthSituation' => 'Good',
        'housingSituation' => 'Own house',
        'personalAutonomy' => 'Independent',
        'economicSituation' => 'Stable',
        'operatorId' => User::factory()->create()->id,
        'languages' => [ 'Catalan', 'English'],
        'status' => 'Admitted',
        'contactPersons' => [
            [
                'firstName' => 'John',
                'lastName' => 'Doe Updated',
                'phone' => '123456789',
                'relationship' => 'parent'
            ],
            [
                'firstName' => 'Marta',
                'lastName' => 'Doe Updated',
                'phone' => '123456789',
                'relationship' => 'sibling'
            ]
        ]
    ];

    $response = putJson("/api/patients/{$patient->id}", $updateData);
    $response->assertStatus(200);
});

it('can delete a patient', function () {
    Sanctum::actingAs(User::factory()->create());

    $patient = \App\Models\Patient::factory()->create();

    $response = delete("/api/patients/{$patient->id}");

    $response->assertStatus(200);
});
