<?php

namespace Support\Concerns;

trait Unguarded
{
    public function initializeUnguarded()
    {
        self::$unguarded = true;
        $this->guarded = [];
    }
}
