<?php

namespace Database\Factories;

use App\Enums\Language;
use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\User;
use App\Enums\UserRole;
use App\Models\Zone;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fullName' => $this->faker->name(),
            'birthDate' => $this->faker->date(),
            'fullAddress' => $this->faker->address(),
            'dni' => $this->faker->randomNumber(8),
            'healthCardNumber' => $this->faker->randomNumber(8),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'zoneId' => Zone::inRandomOrder()->first()->id ?? Zone::factory()->create()->id,
            'operatorId' => User::where('role', UserRole::OPERATOR)->inRandomOrder()->first()->id,
            'personalFamilySituation' => $this->faker->sentence(),
            'healthSituation' => 'health situation random: ' . $this->faker->sentence(),
            'housingSituation' => 'housing situation random: ' . $this->faker->sentence(),
            'personalAutonomy' => 'personal situation random: ' . $this->faker->sentence(),
            'economicSituation' =>'economic situation random: ' .  $this->faker->sentence(),
        ];
    }
}
