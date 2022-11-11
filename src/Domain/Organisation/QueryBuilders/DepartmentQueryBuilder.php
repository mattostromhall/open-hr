<?php

namespace Domain\Organisation\QueryBuilders;

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

    public function filter(string $search = null): self
    {
        return $this->when(
            $search,
            fn () => $this->where('name', 'like', '%' . $search . '%')
        );
    }
}
