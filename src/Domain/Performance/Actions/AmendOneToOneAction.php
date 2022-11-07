<?php

namespace Domain\Performance\Actions;

use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;
use Exception;

class AmendOneToOneAction
{
    public function __construct(
        protected UpdateOneToOneAction $updateOneToOne,
        protected CreateOneToOneRecurrenceAction $createRecurrence,
        protected OneToOneInviteAction $oneToOneInvite
    ) {
        //
    }

    public function execute(OneToOne $oneToOne, OneToOneData $data): bool
    {
        $updated = $this->updateOneToOne->execute($oneToOne, $data);

        if ($updated) {
            try {
                $this->createRecurrence->execute($data);
                $this->oneToOneInvite->execute($oneToOne, $data);
            } catch (Exception) {
                return false;
            }
        }

        return $updated;
    }
}
