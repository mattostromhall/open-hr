<?php

namespace Domain\Performance\Actions;

use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;

class ScheduleOneToOneAction
{
    public function __construct(
        protected CreateOneToOneAction $createOneToOne,
        protected OneToOneInviteAction $oneToOneInvite
    ) {
        //
    }

    public function execute(OneToOneData $data): OneToOne
    {
        $oneToOne = $this->createOneToOne->execute($data);

        $this->oneToOneInvite->execute($oneToOne, $data);

        return $oneToOne;
    }
}
