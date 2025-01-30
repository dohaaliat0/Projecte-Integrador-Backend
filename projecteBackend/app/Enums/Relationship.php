<?php

namespace App\Enums;

enum Relationship: string
{
    case Parent = 'parent';
    case Sibling = 'sibling';
    case Spouse = 'spouse';
    case Child = 'child';
    case Friend = 'friend';
    case Guardian = 'guardian';
    case Other = 'other';
}