<?php

namespace Support\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class ReportQueryBuilder extends Builder
{

    public function filter(string $search = null): self
    {
        return $this->when(
            $search,
            fn () => $this->where('label', 'like', '%' . $search . '%')
        );
    }
}
