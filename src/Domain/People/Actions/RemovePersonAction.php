<?php

namespace Domain\People\Actions;

use Domain\Organisation\Actions\Contracts\ReassignHeadOfDepartmentActionInterface;
use Domain\People\Actions\Contracts\DeletePersonUserActionInterface;
use Domain\People\Actions\Contracts\ReassignManagerFromPersonActionInterface;
use Domain\People\Actions\Contracts\RemovePersonActionInterface;
use Domain\People\DataTransferObjects\RemovePersonData;

class RemovePersonAction implements RemovePersonActionInterface
{
    public function __construct(
        protected DeletePersonUserActionInterface $deletePersonUser,
        protected ReassignManagerFromPersonActionInterface $reassignManager,
        protected ReassignHeadOfDepartmentActionInterface $reassignHeadOfDepartment
    ) {
        //
    }

    public function execute(RemovePersonData $data): bool
    {
        if ($data->new_head_of_department_id) {
            $this->reassignHeadOfDepartment->execute($data->department, $data->new_head_of_department_id);
        }

        $this->reassignManager->execute($data->person, $data->new_manager_id);

        return $this->deletePersonUser->execute($data->person, $data->user);
    }
}
