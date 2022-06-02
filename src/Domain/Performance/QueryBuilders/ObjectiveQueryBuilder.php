<?php

namespace Domain\Performance\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class ObjectiveQueryBuilder extends Builder
{
    public function active(): self
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
}
