<?php

namespace Domain\Organisation\Actions;

use Domain\Files\Actions\StoreFileAction;
use Domain\Files\DataTransferObjects\UploadedFileData;
use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\Organisation\DataTransferObjects\OrganisationData;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Illuminate\Http\UploadedFile;

class UpdateDepartmentAction
{
    public function execute(Department $department, DepartmentData $data): bool
    {
        return $department->update([
            'name' => $data->name,
            'head_of_department_id' => $data->head->id,
        ]);
    }
}
