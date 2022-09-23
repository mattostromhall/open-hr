<?php

namespace Domain\Organisation\QueryBuilders;

use Domain\Absences\Enums\HolidayStatus;
use Domain\Organisation\Enums\OrganisationYear;
use Illuminate\Database\Eloquent\Builder;

class DepartmentQueryBuilder extends Builder
{
    public function includeSize(): self
    {
        return $this->withCount('members');
    }

    public function includeHead(): self
    {
        return $this->with('head:id,first_name,last_name');
    }
}
