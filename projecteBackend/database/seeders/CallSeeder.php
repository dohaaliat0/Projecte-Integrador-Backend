<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Call;
use App\Models\IncomingCall;
use App\Models\OutgoingCall;

class CallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $call = Call::factory()->create();
            IncomingCall::factory()->create([
                'callId' => $call->id,
            ]);
        }

        // OutgoingCall::factory()
        //     ->count(10)
        //     ->create()
        //     ->each(function ($outgoingCall) {
        //         $call = Call::factory()->create();
        //         $outgoingCall->call()->associate($call);
        //         $outgoingCall->save();
        //     });
    }
}
