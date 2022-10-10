<?php

namespace Domain\Recruitment\Enums;

enum ApplicationStatus: int
{
    case PENDING = 1;
    case SUCCESSFUL = 2;
    case UNSUCCESSFUL = 3;
}
