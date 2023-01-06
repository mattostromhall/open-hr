<?php

namespace Domain\Performance\QueryBuilders;

use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ObjectiveQueryBuilder extends Builder
{
    public function current(): self
    {
        return $this->whereNull('completed_at');
    }

    public function completed(): self
    {
        return $this->whereNotNull('completed_at');
    }

    public function overdue(): self
    {
        return $this->where('due_at', '<', now());
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
