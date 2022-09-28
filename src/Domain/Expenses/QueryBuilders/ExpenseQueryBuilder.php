<?php

namespace Domain\Expenses\QueryBuilders;

use Domain\Expenses\Enums\ExpenseStatus;
use Illuminate\Database\Eloquent\Builder;

class ExpenseQueryBuilder extends Builder
{
    public function wherePending(): self
    {
        return $this->where('status', ExpenseStatus::PENDING);
    }

    public function whereNotPending(): self
    {
        return $this->whereNot('status', ExpenseStatus::PENDING);
    }

    public function whereApproved(): self
    {
        return $this->where('status', ExpenseStatus::APPROVED);
    }

    public function whereNotApproved(): self
    {
        return $this->whereNot('status', ExpenseStatus::APPROVED);
    }

    public function whereRejected(): self
    {
        return $this->where('status', ExpenseStatus::REJECTED);
    }

    public function whereNotRejected(): self
    {
        return $this->whereNot('status', ExpenseStatus::REJECTED);
    }
}
