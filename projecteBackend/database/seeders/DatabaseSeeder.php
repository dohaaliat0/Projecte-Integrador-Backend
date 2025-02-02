<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Alert;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            ZonesSeeder::class,
            ZonesUsersSeeder::class,
            PatientsSeeder::class,
            ContactPersonSeeder::class,
            LanguageSeeder::class,
            LanguageUserPatientSeeder::class,
            AlertSeeder::class,
            // CallSeeder::class,
            // PatientHistorySeeder::class,
        ]);
    }
}
