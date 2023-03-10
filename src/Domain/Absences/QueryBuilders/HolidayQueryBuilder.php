<?php

namespace Domain\Absences\QueryBuilders;

use Domain\Absences\Enums\HolidayStatus;
use Domain\Organisation\Enums\OrganisationYear;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class HolidayQueryBuilder extends Builder
{
    public function wherePending(): self
    {
        return $this->where('status', HolidayStatus::PENDING);
    }

    public function whereNotPending(): self
    {
        return $this->whereNot('status', HolidayStatus::PENDING);
    }

    public function whereApproved(): self
    {
        return $this->where('status', HolidayStatus::APPROVED);
    }

    public function whereNotApproved(): self
    {
        return $this->whereNot('status', HolidayStatus::APPROVED);
    }

    public function whereRejected(): self
    {
        return $this->where('status', HolidayStatus::REJECTED);
    }

    public function whereNotRejected(): self
    {
        return $this->whereNot('status', HolidayStatus::REJECTED);
    }

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
