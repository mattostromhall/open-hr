<?php

namespace Domain\Performance\Enums;

enum RecurrenceInterval: string
{
    case WEEKLY = 'weekly';
    case FORTNIGHTLY = 'fortnightly';
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case BIANNUALLY = 'biannually';
}
