<?php

namespace Support\DataTransferObjects;

use Illuminate\Support\Collection;

class ReportData extends DataTransferObject
{
    /**
     * @param string $model
     * @param Collection<ReportConditionGroupData> $conditionGroups
     */
    public function __construct(
        public readonly string $model,
        public readonly Collection $conditionGroups
    ) {
        //
    }
}
