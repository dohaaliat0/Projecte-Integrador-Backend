<?php

namespace Database\Factories;

use App\Enums\OutgoingCallsType;
use App\Models\Alert;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OutgoingCall>
 */
class OutgoingCallFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $alertId = null;
        if (rand(0, 1) == 0) {
            $alertId = Alert::all()->random()->id;
        }

        $types = OutgoingCallsType::values();
        $type = $types[array_rand($types)];

        return [
            'type' => $type,
            'alertId' => $alertId,
        ];
    }
}
