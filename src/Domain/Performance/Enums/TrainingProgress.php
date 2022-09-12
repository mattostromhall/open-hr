<?php

namespace Domain\Performance\Enums;

enum TrainingProgress: int
{
    case TODO = 1;
    case STARTED = 2;
    case COMPLETED = 3;

    public function statusDisplay(): string
    {
        return match ($this) {
            self::TODO => 'todo',
            self::STARTED => 'started',
            self::COMPLETED => 'completed',
        };
    }
}
