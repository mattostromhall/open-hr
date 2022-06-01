<?php

namespace Domain\Absences\QueryBuilders;

use Domain\Organisation\Enums\OrganisationYear;
use Illuminate\Database\Eloquent\Builder;

class SicknessQueryBuilder extends Builder
{
    public function forCurrentYear(): self
    {
        return $this->where('start_at', '>=', OrganisationYear::ABSENCE->start());
    }
}
