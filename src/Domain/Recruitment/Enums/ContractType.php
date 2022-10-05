<?php

namespace Domain\Recruitment\Enums;

enum ContractType: string
{
    case FIXED_TERM = 'fixed term';
    case FULL_TIME = 'full time';
    case PART_TIME = 'part time';
    case FREELANCER = 'freelancer';
    case APPRENTICESHIP = 'apprenticeship';
    case INTERNSHIP = 'internship';
}
