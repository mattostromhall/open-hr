<?php

namespace Domain\People\Actions;

use Domain\Auth\Actions\Contracts\DeleteUserActionInterface;
use Domain\Auth\Models\User;
use Domain\Organisation\Actions\Contracts\ReassignHeadOfDepartmentActionInterface;
use Domain\People\Actions\Contracts\DeletePersonActionInterface;
use Domain\People\Actions\Contracts\DeletePersonUserActionInterface;
use Domain\People\Actions\Contracts\ReassignManagerFromPersonActionInterface;
use Domain\People\DataTransferObjects\DeletePersonData;
use Domain\People\Models\Person;

class DeletePersonUserAction implements DeletePersonUserActionInterface
{
    public function __construct(
        protected DeletePersonActionInterface $deletePerson,
        protected DeleteUserActionInterface $deleteUser,
        protected ReassignManagerFromPersonActionInterface $reassignManager,
        protected ReassignHeadOfDepartmentActionInterface $reassignHeadOfDepartment
    ) {
        //
    }

    public function execute(DeletePersonData $data): bool
    {
        $this->reassignManager->execute($data->person, $data->new_manager_id);
        $this->reassignHeadOfDepartment->execute($data->department, $data->new_manager_id);

        return $this->deletePerson->execute($data->person)
            && $this->deleteUser->execute($data->user);
    }
}
