<?php

namespace App\Models;

use App\Enums\DayOfWeek;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = ['user_id', 'zone_id', 'type', 'isRecurring', 'date', 'endDate', 'time', 'dayOfWeek', 'description'];

    public function casts(){
        [
            'dayOfWeek' => DayOfWeek::class,
        ];
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function zone() {
        return $this->belongsTo(Zone::class);
    }


}
