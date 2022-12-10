<?php

namespace Support\Concerns;

trait Unguarded
{
    public function initializeUnguarded(): void
    {
        self::$unguarded = true;
        $this->guarded = [];
    }
}
