<?php

namespace Domain\Absences\QueryBuilders;

use Domain\Organisation\Enums\OrganisationYear;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SicknessQueryBuilder extends Builder
{
    public function forCurrentYear(): self
    {
        return $this->where('start_at', '>=', OrganisationYear::ABSENCE->start());
    }

    /**
     * @param Collection<Person> $people
     * @return self
     */
    public function forPeople(Collection $people): self
    {
        return $this->whereIn('person_id', $people->pluck('id'));
    }
}
