<?php

namespace Domain\People\DataTransferObjects;

use Domain\Auth\Models\User;
use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;
use Support\DataTransferObjects\DataTransferObject;

class DeletePersonData extends DataTransferObject
{
    public function __construct(
        public readonly Person $person,
        public readonly User $user,
        public readonly ?Department $department = null,
        public readonly ?int $new_manager_id = null,
        public readonly ?int $new_head_of_department_id = null,
    ) {
        //
    }
}
