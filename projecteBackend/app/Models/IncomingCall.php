<?php

namespace App\Models;

use App\Enums\IncomingCallsType;
use App\Enums\OutgoingCallsType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class IncomingCall extends Model
{
    use HasFactory;
    protected $fillable = ['callId', 'type', 'emergencyLevel'];
    public $timestamps = false;


    public function call() {
        return $this->belongsTo(Call::class);
    }
}
