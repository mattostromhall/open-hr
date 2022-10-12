<?php

namespace Domain\Recruitment\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VacancyQueryBuilder extends Builder
{
    public function whereOpen(): self
    {
        return $this->where('open_at', '<=', now())
            ->where('close_at', '>', now())
            ->orWhereNull('close_at');
    }

    public function whereClosed(): self
    {
        return $this->where('close_at', '<=', now());
    }
}
