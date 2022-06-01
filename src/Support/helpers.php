<?php

use Domain\Organisation\Models\Organisation;

if (! function_exists('organisation')) {
    function organisation()
    {
        return Organisation::first();
    }
}

if (! function_exists('person')) {
    function person()
    {
        return auth()->user()?->person;
    }
}
