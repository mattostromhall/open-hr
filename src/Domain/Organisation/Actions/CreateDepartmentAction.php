<?php

namespace Domain\Organisation\Actions;

use Domain\Files\Actions\StoreFileAction;
use Domain\Files\DataTransferObjects\UploadedFileData;
use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\Organisation\DataTransferObjects\OrganisationData;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Illuminate\Http\UploadedFile;

class CreateDepartmentAction
{
    public function execute(DepartmentData $data): Department
    {
        return Department::create([
            'name' => $data->name,
            'head_of_department_id' => $data->head->id,
        ]);
    }
}
