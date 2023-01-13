<?php

namespace Domain\People\Actions\Contracts;

use Domain\People\Models\Person;

interface ManageDirectReportsActionInterface
{
    public function execute(Person $person, array $people): void;
}
