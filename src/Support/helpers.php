<?php

if (! function_exists('person')) {
    function person()
    {
        return auth()->user()?->person;
    }
}
