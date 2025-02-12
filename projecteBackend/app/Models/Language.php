<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Language as LanguageEnum;

class Language extends Model
{
    protected $fillable = ['name'];

    public function patients()
    {
        return $this->belongsToMany(Patient::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getNameAttribute($value)
    {
        return LanguageEnum::tryFrom($value)?->label() ?? $value;
    }

    public static function isValidId($id)
    {
        return self::where('id', $id)->exists();
    }
}
