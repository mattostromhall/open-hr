<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\CreateOneToOneActionInterface;
use Domain\Performance\Actions\Contracts\OneToOneInviteActionInterface;
use Domain\Performance\Actions\Contracts\ScheduleOneToOneActionInterface;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;

class ScheduleOneToOneAction implements ScheduleOneToOneActionInterface
{
    public function __construct(
        protected CreateOneToOneActionInterface $createOneToOne,
        protected OneToOneInviteActionInterface $oneToOneInvite
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
