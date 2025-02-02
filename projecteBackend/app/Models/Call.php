<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Call extends Model
{
    use HasFactory;
    protected $fillable = ['patientId', 'operatorId', 'details', 'dateTime'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function operator() {
        return $this->belongsTo(User::class);
    }
}
