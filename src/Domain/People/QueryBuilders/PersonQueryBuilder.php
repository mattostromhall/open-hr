<?php

namespace Domain\People\QueryBuilders;

use Domain\Organisation\QueryBuilders\DepartmentQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonQueryBuilder extends Builder
{
    public function holidayThisYear(): HasMany
    {
        return $this->model
            ->holidays()
            ->forCurrentYear()
            ->whereApproved();
    }

    public function sicknessThisYear(): HasMany
    {
        return $this->model
            ->sicknesses()
            ->forCurrentYear();
    }

    public function current(): self
    {
        return $this->whereNull('finished_on')
            ->orWhere('finished_on', '>', now());
    }

    public function filter(string $search = null): self
    {
        return $this->when(
            $search,
            fn () => $this
                ->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('position', 'like', '%' . $search . '%')
                ->orWhereHas('department', function (DepartmentQueryBuilder $query) use ($search) {
                    $query->filter($search);
                })
        );
    }
}
