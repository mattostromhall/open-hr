<?php

namespace Domain\Auth\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case PERSON = 'person';
}
