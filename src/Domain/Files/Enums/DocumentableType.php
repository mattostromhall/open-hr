<?php

namespace Domain\Files\Enums;

enum DocumentableType: string
{
    case APPLICATIONS = 'applications';
    case EXPENSES = 'expenses';
    case ORGANISATION = 'organisation';
    case PEOPLE = 'people';
    case VACANCIES = 'vacancies';
}
