<?php

namespace Domain\Performance\Actions;

use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;

class AmendOneToOneAction
{
    public function __construct(
        protected UpdateOneToOneAction $updateOneToOne,
        protected OneToOneInviteAction $oneToOneInvite
    ) {
        //
    }

    public function execute(OneToOne $oneToOne, OneToOneData $data): bool
    {
        $updated = $this->updateOneToOne->execute($oneToOne, $data);

        if ($updated) {
            $this->oneToOneInvite->execute($oneToOne, $data);
        }

        return $updated;
    }
}
