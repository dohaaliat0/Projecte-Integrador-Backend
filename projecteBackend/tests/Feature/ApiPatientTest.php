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
use App\Models\Zone;
use App\Models\Language;
use App\Models\Patient;
use App\Models\Call;

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
        'zoneId' => Zone::factory()->create()->id,
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

    $patient = Patient::factory()->create();

    $response = get("/api/patients/{$patient->id}");

    $response->assertStatus(200);
});

it('can update a patient', function () {
    Sanctum::actingAs(User::factory()->create());

    $patient = Patient::factory()->create();

    $updateData = [
        'fullName' => 'John Doe Updated',
        'birthDate' => '1990-01-01',
        'fullAddress' => '123 Main St, Anytown, USA Updated',
        'dni' => '12345678A',
        'healthCardNumber' => 'HC123456',
        'phone' => '123-456-7890',
        'email' => 'john.doe.updated@example.com',
        'zoneId' =>Zone::factory()->create()->id,
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

    $patient = Patient::factory()->create();

    $response = delete("/api/patients/{$patient->id}");

    $response->assertStatus(200);
});

it('can filter patients by zoneId', function () {
    Sanctum::actingAs(User::factory()->create());

    $zone =Zone::factory()->create();
    Patient::factory()->create(['zoneId' => $zone->id]);

    $response = get('/api/patients?zoneId=' . $zone->id);

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
});

it('can filter patients by operatorId', function () {
    Sanctum::actingAs(User::factory()->create());

    $operator = User::factory()->create();
    Patient::factory()->create(['operatorId' => $operator->id]);

    $response = get('/api/patients?operatorId=' . $operator->id);

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
});

it('can filter patients by status', function () {
    Sanctum::actingAs(User::factory()->create());

    Patient::factory()->create(['status' => 'Admitted']);

    $response = get('/api/patients?status=Admitted');

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
});

it('can get call history by patient', function () {
    Sanctum::actingAs(User::factory()->create());

    $patient = Patient::factory()->create();
    Call::factory()->create(['patientId' => $patient->id]);

    $response = get("/api/patients/{$patient->id}/calls");

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
});

it('returns validation errors when creating a patient with invalid data', function () {
    Sanctum::actingAs(User::factory()->create());

    $invalidPatientData = [
        'fullName' => '',
        'birthDate' => 'invalid-date',
        'fullAddress' => '',
        'dni' => '',
        'healthCardNumber' => '',
        'phone' => '',
        'email' => 'invalid-email',
        'zoneId' => null,
        'personalFamilySituation' => '',
        'healthSituation' => '',
        'housingSituation' => '',
        'personalAutonomy' => '',
        'economicSituation' => '',
        'operatorId' => null,
        'languages' => [],
        'status' => '',
        'contactPersons' => []
    ];

    $response = postJson('/api/patients', $invalidPatientData);
    $response->assertStatus(422);
});

it('returns validation errors when updating a patient with invalid data', function () {
    Sanctum::actingAs(User::factory()->create());

    $patient = Patient::factory()->create();

    $invalidUpdateData = [
        'fullName' => '',
        'birthDate' => 'invalid-date',
        'fullAddress' => '',
        'dni' => '',
        'healthCardNumber' => '',
        'phone' => '',
        'email' => 'invalid-email',
        'zoneId' => null,
        'personalFamilySituation' => '',
        'healthSituation' => '',
        'housingSituation' => '',
        'personalAutonomy' => '',
        'economicSituation' => '',
        'operatorId' => null,
        'languages' => [],
        'status' => '',
        'contactPersons' => []
    ];

    $response = putJson("/api/patients/{$patient->id}", $invalidUpdateData);
    $response->assertStatus(422);
});

it('returns 404 when trying to show a non-existent patient', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = get('/api/patients/999999');

    $response->assertStatus(404);
});

it('returns 404 when trying to update a non-existent patient', function () {
    Sanctum::actingAs(User::factory()->create());

    $updateData = [
        'fullName' => 'John Doe Updated',
        'birthDate' => '1990-01-01',
        'fullAddress' => '123 Main St, Anytown, USA Updated',
        'dni' => '12345678A',
        'healthCardNumber' => 'HC123456',
        'phone' => '123-456-7890',
        'email' => 'john.doe.updated@example.com',
        'zoneId' =>Zone::factory()->create()->id,
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

    $response = putJson('/api/patients/999999', $updateData);
    $response->assertStatus(404);
});

it('returns 404 when trying to delete a non-existent patient', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = delete('/api/patients/999999');

    $response->assertStatus(404);
});


it('can create a patient with a language', function () {
    Sanctum::actingAs(User::factory()->create());

    // Create a language
    Language::create(['name' => 'Catalan']);
    // Prepare patient data
    $patientData = [
        'fullName' => 'John Doe',
        'birthDate' => '1980-01-01',
        'fullAddress' => '123 Main St, Anytown, USA',
        'dni' => '12345678A',
        'healthCardNumber' => 'HC123456',
        'phone' => '123-456-7890',
        'email' => 'john.doe@example.com',
        'zoneId' => Zone::factory()->create()->id,
        'personalFamilySituation' => 'Single',
        'healthSituation' => 'Good',
        'housingSituation' => 'Own house',
        'personalAutonomy' => 'Independent',
        'economicSituation' => 'Stable',
        'operatorId' => User::factory()->create()->id,
        'languages' => [1], 
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

    // Send the request to create a patient
    $response = postJson('/api/patients', $patientData);
    // Assert the response status
    $response->assertStatus(201);
});

it('handles exception when creating a patient with an invalid language ID', function () {
    Sanctum::actingAs(User::factory()->create());

    // Prepare patient data with an invalid language ID
    $patientData = [
        'fullName' => 'John Doe',
        'birthDate' => '1980-01-01',
        'fullAddress' => '123 Main St, Anytown, USA',
        'dni' => '12345678A',
        'healthCardNumber' => 'HC123456',
        'phone' => '123-456-7890',
        'email' => 'john.doe@example.com',
        'zoneId' => Zone::factory()->create()->id,
        'personalFamilySituation' => 'Single',
        'healthSituation' => 'Good',
        'housingSituation' => 'Own house',
        'personalAutonomy' => 'Independent',
        'economicSituation' => 'Stable',
        'operatorId' => User::factory()->create()->id,
        'languages' => [999999], // Invalid language ID
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

    // Send the request to create a patient
    $response = postJson('/api/patients', $patientData);

    // Assert the response status and message
    $response->assertStatus(422);
    $response->assertJson([
        'message' => 'The selected languages is invalid.'
    ]);
});