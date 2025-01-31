<?php

namespace App\Enums;

enum Language: string
{
    case SPANISH = 'Spanish';
    case CATALAN = 'Catalan';
    case GALICIAN = 'Galician';
    case BASQUE = 'Basque';
    case ARANESE = 'Aranese';
    case ENGLISH = 'English';
    case FRENCH = 'French';
    case ROMANIAN = 'Romanian';
    case ARABIC = 'Arabic';
    case PORTUGUESE = 'Portuguese';
    case GERMAN = 'German';
    case ITALIAN = 'Italian';
    case CHINESE = 'Chinese';
    case BULGARIAN = 'Bulgarian';
    case UKRAINIAN = 'Ukrainian';
    case POLISH = 'Polish';
    case DUTCH = 'Dutch';
    case RUSSIAN = 'Russian';
    case WOLLOF = 'Wolof';
    case PULAA = 'Pulaa';
    case HINDI = 'Hindi';
    case BENGALI = 'Bengali';
    case URDU = 'Urdu';
    case GUJARATI = 'Gujarati';
    case PUNJABI = 'Punjabi';
    case TAGALOG = 'Tagalog';
    case JAPANESE = 'Japanese';
    case KOREAN = 'Korean';
    case SWAHILI = 'Swahili';
    case AMHARIC = 'Amharic';

    public function label(): string
    {
        return match ($this) {
            self::SPANISH => 'Español',
            self::CATALAN => 'Català',
            self::GALICIAN => 'Galego',
            self::BASQUE => 'Euskara',
            self::ARANESE => 'Aranès',
            default => $this->value, 
        };
    }


    public static function toArray(): array
    {
        return [
            self::SPANISH,
            self::CATALAN,
            self::GALICIAN,
            self::BASQUE,
            self::ARANESE,
            self::ENGLISH,
            self::FRENCH,
            self::ROMANIAN,
            self::ARABIC,
            self::PORTUGUESE,
            self::GERMAN,
            self::ITALIAN,
            self::CHINESE,
            self::BULGARIAN,
            self::UKRAINIAN,
            self::POLISH,
            self::DUTCH,
            self::RUSSIAN,
            self::WOLLOF,
            self::PULAA,
            self::HINDI,
            self::BENGALI,
            self::URDU,
            self::GUJARATI,
            self::PUNJABI,
            self::TAGALOG,
            self::JAPANESE,
            self::KOREAN,
            self::SWAHILI,
            self::AMHARIC,
        ];
    }
}
