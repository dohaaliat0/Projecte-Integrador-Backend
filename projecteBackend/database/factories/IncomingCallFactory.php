<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\IncomingCallsType;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IncomingCall>
 */
class IncomingCallFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = IncomingCallsType::values();

        return [
            'type' => $types[array_rand($types)],
        ];
    }
}
