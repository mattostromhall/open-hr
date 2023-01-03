<?php

namespace Domain\Notifications\Enums;

enum NotifiableType: string
{
    case DEPARTMENT = 'department';
    case ORGANISATION = 'organisation';
    case PERSON = 'person';
}
