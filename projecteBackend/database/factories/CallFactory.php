<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Call>
 */
class CallFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patientId' => Patient::count() > 0 ? Patient::all()->random()->id : Patient::factory()->create()->id,
            'operatorId' => User::where('role', UserRole::OPERATOR)->count() > 0 ? User::where('role', UserRole::OPERATOR)->get()->random()->id : User::factory()->create()->id,
            'details' => $this->faker->text,
            'dateTime' => Carbon::now()->subDays(rand(0, 10))->addDays(rand(0, 20))->subMinutes(rand(0, 60 * 24 * 30)),
        ];
    }
}
