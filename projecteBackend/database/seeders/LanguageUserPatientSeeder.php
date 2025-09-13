<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use App\Models\Language;
use App\Enums\Language as LanguageEnum;

class LanguageUserPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = Language::all();
        $mandatoryLanguages = Language::whereIn('name', [LanguageEnum::SPANISH, LanguageEnum::CATALAN])->get();
        $patients = Patient::all();
        $users = User::all();

        $patients->each(function ($patient) use ($languages, $mandatoryLanguages) {
            $randomNumber = rand(1, 4);
            if ($randomNumber === 1) {
                $patient->languages()->attach($languages->random());
                $patient->languages()->attach($mandatoryLanguages);

            } elseif ($randomNumber === 2) {
                $patient->languages()->attach($languages->random());
                $patient->languages()->attach($mandatoryLanguages->random());
            }elseif ($randomNumber === 3) {
                $patient->languages()->attach($mandatoryLanguages);
            } else {
                $patient->languages()->attach($mandatoryLanguages->random());
            }
        });

        $users->each(function ($user) use ($languages, $mandatoryLanguages) {
            $randomNumber = rand(1, 4);
            if ($randomNumber === 1) {
                $user->languages()->attach($languages->random());
                $user->languages()->attach($mandatoryLanguages);

            } elseif ($randomNumber === 2) {
                $user->languages()->attach($languages->random());
                $user->languages()->attach($mandatoryLanguages->random());
            }elseif ($randomNumber === 3) {
                $user->languages()->attach($mandatoryLanguages);
            } else {
                $user->languages()->attach($mandatoryLanguages->random());
            }
        });
    }
}
