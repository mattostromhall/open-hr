<?php

namespace Domain\Performance\QueryBuilders;

use Domain\Performance\Enums\OneToOneStatus;
use Illuminate\Database\Eloquent\Builder;

class OneToOneQueryBuilder extends Builder
{
    public function whereStatusInvited(): self
    {
        return $this->where('person_status', OneToOneStatus::INVITED)
            ->orWhere('manager_status', OneToOneStatus::INVITED);
    }

    public function whereStatusAccepted(): self
    {
        return $this->where('person_status', OneToOneStatus::ACCEPTED)
            ->where('manager_status', OneToOneStatus::ACCEPTED);
    }

    public function upcoming(): self
    {
        return $this->where('scheduled_at', '>', now())
            ->where(function (self $query) {
                $query->where(fn (self $query) => $query->whereStatusInvited());
                $query->orWhere(fn (self $query) => $query->whereStatusAccepted());
            })
            ->orderBy('scheduled_at');
    }
}
