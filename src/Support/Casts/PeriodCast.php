<?php

namespace Support\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Support\ValueObjects\Period;

class PeriodCast implements CastsAttributes
{
    public function get($model, string $key, mixed $value, array $attributes): Period
    {
        return Period::fromDateStrings(
            $attributes['start_at'],
            $attributes['finish_at']
        );
    }

    public function set($model, string $key, mixed $value, array $attributes): array
    {
        if (! $value instanceof Period) {
            throw new InvalidArgumentException('The given value is not a Period instance.');
        }

        return [
            'start_at' => $value->start()->toDateString(),
            'finish_at' => $value->finish()->toDateString(),
        ];
    }
}
