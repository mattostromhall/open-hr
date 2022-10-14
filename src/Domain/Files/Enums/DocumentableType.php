<?php

namespace Domain\Files\Enums;

use Illuminate\Support\Str;

enum DocumentableType: string
{
    case APPLICATION = 'application';
    case DEPARTMENT = 'department';
    case EXPENSE = 'expense';
    case ORGANISATION = 'organisation';
    case PERSON = 'person';
    case SICKNESS = 'sickness';
    case VACANCY = 'vacancy';

    public function plural(): string
    {
        return match ($this) {
            self::ORGANISATION => $this->value,
            self::APPLICATION,
            self::DEPARTMENT,
            self::EXPENSE,
            self::PERSON,
            self::SICKNESS,
            self::VACANCY => Str::plural($this->value)
        };
    }

    public static function fromPlural(string $plural): self
    {
        $singular = Str::singular($plural);

        return self::from($singular);
    }
}
