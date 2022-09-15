<?php

namespace Domain\Performance\QueryBuilders;

use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Enums\TrainingStatus;
use Illuminate\Database\Eloquent\Builder;

class TrainingQueryBuilder extends Builder
{
    public function approved(): self
    {
        return $this->where('status', TrainingStatus::APPROVED);
    }

    public function awaitingApproval(): self
    {
        return $this->where('status', TrainingStatus::PENDING);
    }

    public function notStarted(): self
    {
        return $this->where('state', TrainingState::TODO);
    }

    public function started(): self
    {
        return $this->where('state', TrainingState::STARTED);
    }

    public function completed(): self
    {
        return $this->where('state', TrainingState::COMPLETED);
    }
}
