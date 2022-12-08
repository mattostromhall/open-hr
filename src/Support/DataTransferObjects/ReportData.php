<?php

namespace Support\DataTransferObjects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ReportData extends DataTransferObject
{
    /**
     * @param Model $model
     * @param Collection<ReportConditionGroupData> $conditionGroups
     */
    public function __construct(
        public readonly Model $model,
        public readonly Collection $conditionGroups
    ) {
        //
    }
}
