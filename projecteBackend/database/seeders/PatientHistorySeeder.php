<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PatientHistory;
use App\Models\User;
use App\Models\Patient;
use App\Enums\UserRole;

class PatientHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $operators = User::where('role', UserRole::OPERATOR)->get();
        $patients = Patient::all();


        foreach ($patients as $patient) {
            $patientLanguages = $patient->languages()->pluck('id')->toArray();
            $matchingOperators = $operators->filter(function ($operator) use ($patientLanguages) {
                return $operator->languages()->whereIn('id', $patientLanguages)->exists();
            });

            if ($matchingOperators->isNotEmpty()) {
                PatientHistory::create([
                    'operatorId' => $matchingOperators->random()->id,
                    'patientId' => $patient->id,
                    'dateTime' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}
