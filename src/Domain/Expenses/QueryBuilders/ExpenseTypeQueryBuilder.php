<?php

namespace Domain\Expenses\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class ExpenseTypeQueryBuilder extends Builder
{
    public function filter(string $search = null): self
    {
        return $this->when(
            $search,
            fn () => $this->where('type', 'like', '%' . $search . '%')
        );
    }
}
