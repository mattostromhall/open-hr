<?php

namespace Domain\Performance\Enums;

enum TrainingState: int
{
    case TODO = 1;
    case STARTED = 2;
    case COMPLETED = 3;

    public function stateDisplay(): string
    {
        return match ($this) {
            self::TODO => 'not started',
            self::STARTED => 'started',
            self::COMPLETED => 'completed',
        };
    }
}
