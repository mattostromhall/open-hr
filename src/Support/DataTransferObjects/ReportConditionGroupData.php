<?php

namespace Support\DataTransferObjects;

use Illuminate\Support\Collection;

class ReportConditionGroupData extends DataTransferObject
{
    /**
     * @param Collection<ReportConditionData> $conditions
     * @param string $type
     */
    public function __construct(
        public readonly Collection $conditions,
        public readonly string $type = 'and'
    ) {
        //
    }
}
