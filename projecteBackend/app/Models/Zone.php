<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zones';
    protected $fillable = ['name', 'status'];
    public $timestamps = true;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_zone');
    }
}
