<?php

namespace Support\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Money implements CastsAttributes
{
    public function get($model, string $key, mixed $value, array $attributes): int | float
    {
        return $value / 100;
    }

    public function set($model, string $key, mixed $value, array $attributes): int | float
    {
        return $value * 100;
    }
}
