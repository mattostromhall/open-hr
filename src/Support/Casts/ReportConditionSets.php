<?php

namespace Support\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\DataTransferObjects\ReportConditionSetData;

class ReportConditionSets implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Collection<ReportConditionSetData>
     */
    public function get($model, string $key, $value, array $attributes): Collection
    {
        return collect(json_decode($value, true))
            ->map(
                fn (array $conditionSet) =>
                ReportConditionSetData::fromArray($conditionSet)
            );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return string|bool
     */
    public function set($model, string $key, $value, array $attributes): string|bool
    {
        return json_encode($value);
    }
}
