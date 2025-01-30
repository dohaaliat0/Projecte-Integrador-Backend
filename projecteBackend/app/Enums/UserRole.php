<?php

namespace App\Enums;

enum UserRole: string {
    case COORDINATOR = 'coordinator';
    case OPERATOR = 'operator';

    public function label(): string {
        return match ($this) {
            self::COORDINATOR => '',
            self::OPERATOR => 'Teleoperador',
        };
    }
}
