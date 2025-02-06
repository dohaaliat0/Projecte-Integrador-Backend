<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zones';
    protected $fillable = ['name', 'status'];
    public $timestamps = true;


    
    public function operators()
    {
        return $this->belongsToMany(User::class, 'user_zone', 'zone_id', 'user_id')->where('role', 'operator');
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'zoneId');
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class, 'zoneId');
    }
}
