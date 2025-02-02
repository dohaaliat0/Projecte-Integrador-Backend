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
            'patientId' => Patient::all()->random()->id,
            'operatorId' => User::where('role', UserRole::OPERATOR)->get()->random()->id,
            'details' => $this->faker->text,
            'dateTime' => Carbon::now(),
        ];
    }
}
