<?php 
namespace App\Enums;

enum TypeZones : string {
    case GOOD = 'good';
    case WARNING = 'warning';
    case DANGER = 'danger';
    case EVACUATED = 'evacuated';

    public function label(): string
    {
        return match($this) {
            self::GOOD => 'Good',
            self::WARNING => 'Warning',
            self::DANGER => 'Danger',
            self::EVACUATED => 'Evacuated',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}