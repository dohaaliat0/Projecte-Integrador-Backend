<?php

namespace App\Models;

use App\Enums\OutgoingCallsType;
use Illuminate\Database\Eloquent\Model;

class OutgoingCall extends Model
{
    protected $fillable = ['callId', 'type', 'alertId'];

    public function casts(){
        [
            'type' => OutgoingCallsType::class,
        ];
    }

    public function call() {
        return $this->belongsTo(Call::class);
    }
}
