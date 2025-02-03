<?php

namespace App\Models;

use App\Enums\OutgoingCallsType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class OutgoingCall extends Model
{
    use HasFactory;
    protected $fillable = ['callId', 'type', 'alertId'];
    public $timestamps = false;
    protected $primaryKey = 'callId';



    public function call() {
        return $this->belongsTo(Call::class, 'callId');
    }

    public function alert() {
        return $this->belongsTo(Alert::class);
    }
}
