<?php

use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;

if (! function_exists('organisation')) {
    function organisation(): Organisation
    {
        return Organisation::first();
    }
}

if (! function_exists('person')) {
    function person(): ?Person
    {
        return auth()->user()?->person;
    }
}
