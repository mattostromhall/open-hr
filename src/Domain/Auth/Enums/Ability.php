<?php

namespace Domain\Auth\Enums;

enum Ability: string
{
    case REVIEW_HOLIDAY = 'review-holiday';
    case CREATE_ANNOUNCEMENTS = 'create-announcements';
    case ASSIGN_ABILITIES = 'assign-abilities';
}
