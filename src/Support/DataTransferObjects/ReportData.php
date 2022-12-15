<?php

namespace Support\DataTransferObjects;

use Illuminate\Support\Collection;

class ReportData extends DataTransferObject
{
    /**
     * @param string $model
     * @param Collection<ReportConditionSetData> $condition_sets
     */
    public function __construct(
        public readonly string $model,
        public readonly Collection $condition_sets
    ) {
        //
    }
}
