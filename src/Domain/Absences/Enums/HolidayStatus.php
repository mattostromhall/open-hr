<?php

namespace Domain\Absences\Enums;

enum HolidayStatus: int
{
    case PENDING = 1;
    case APPROVED = 2;
    case REJECTED = 3;
}
