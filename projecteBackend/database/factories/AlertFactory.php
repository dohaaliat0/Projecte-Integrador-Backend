<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\DayOfWeek;
use App\Models\Zone;
use Carbon\Carbon;
use App\Enums\AlertType;
use App\Enums\UserRole;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alert>
 */
class AlertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = Carbon::parse($this->faker->date());
        $types = AlertType::values();
        $operatorId = User::where('role', UserRole::OPERATOR)->get()->random()->id;
        $patientId = User::all()->random()->id;

        $randNumber = rand(1, 3);
        $randomType = $types[array_rand($types)];

        if ($randNumber == 1) {
            //aviso de paciente puntual
            return [
            'operatorId' => $operatorId,
            'patientId' => $patientId,
            'isActive' => $this->faker->boolean(),
            'type' => $randomType,
            'isRecurring' => false,
            'date' => $date,
            'time' => $this->faker->time(),
            'description' => $this->faker->sentence(),
            'title' => $this->faker->sentence(),
            ];
        } else if ($randNumber == 2) {
            //aviso de zona
            $zones = Zone::all();
            return [
            'operatorId' => $operatorId,
            'zoneId' => $zones->random()->id,
            'isActive' => $this->faker->boolean(),
            'type' => $randomType,
            'date' => $date,
            'time' => $this->faker->time(),
            'description' => $this->faker->sentence(),
            'title' => $this->faker->sentence(),
            ];
        } else {
            //aviso recurrente
            $daysOfWeek = DayOfWeek::values();
            return [
            'operatorId' => $operatorId,
            'patientId' => $patientId,
            'isActive' => $this->faker->boolean(),
            'type' => $randomType,
            'isRecurring' => true,
            'date' => $this->faker->date(),
            'endDate' => $this->faker->date(),
            'time' => $this->faker->time(),
            'dayOfWeek' => implode(', ', $this->faker->randomElements($daysOfWeek, rand(1, 7))),
            'description' => $this->faker->sentence(),
            'title' => $this->faker->sentence(),
            ];
        }
    }
}
