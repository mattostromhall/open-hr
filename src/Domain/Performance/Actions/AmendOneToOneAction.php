<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\AmendOneToOneActionInterface;
use Domain\Performance\Actions\Contracts\CreateOneToOneRecurrenceActionInterface;
use Domain\Performance\Actions\Contracts\OneToOneInviteActionInterface;
use Domain\Performance\Actions\Contracts\UpdateOneToOneActionInterface;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;
use Exception;

class AmendOneToOneAction implements AmendOneToOneActionInterface
{
    public function __construct(
        protected UpdateOneToOneActionInterface $updateOneToOne,
        protected CreateOneToOneRecurrenceActionInterface $createRecurrence,
        protected OneToOneInviteActionInterface $oneToOneInvite
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
