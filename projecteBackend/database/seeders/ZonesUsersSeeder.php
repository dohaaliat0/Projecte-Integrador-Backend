<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZonesUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $zones = Zone::all();
        foreach ($users as $user) {
            $zoneCount = rand(0, 5);
            $zoneIds = $zones->random($zoneCount)->pluck('id')->toArray();
            $user->zones()->attach($zoneIds);
        }
    }
}
