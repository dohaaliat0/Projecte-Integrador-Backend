<?php

namespace App\Models;

use App\Enums\OutgoingCallsType;
use Illuminate\Database\Eloquent\Model;

class IncomingCall extends Model
{
    protected $fillable = ['callId', 'type'];

    public function casts(){
        [
            'type' => IncomingCall::class,
        ];
    }

    public function call() {
        return $this->belongsTo(Call::class);
    }
}
