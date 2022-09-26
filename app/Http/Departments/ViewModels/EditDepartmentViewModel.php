<?php

namespace App\Http\Departments\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;
use Illuminate\Support\Collection;

class EditDepartmentViewModel extends ViewModel
{
    public function __construct(protected Department $department)
    {
        //
    }

    public function department(): Department
    {
        return $this->department;
    }

    public function members(): Collection
    {
        return $this->department
            ->members
            ->pluck('id');
    }

    public function people(): Collection
    {
        return Person::query()
            ->select('id', 'first_name', 'last_name')
            ->get()
            ->mapToSelect();
    }

    public function headOptions(): Collection
    {
        return Person::query()
            ->select('id', 'first_name', 'last_name')
            ->whereNotIn(
                'id',
                fn ($query) =>
                $query->select('head_of_department_id')
                    ->from('departments')
                    ->whereNot('head_of_department_id', $this->department->head_of_department_id)
            )
            ->get()
            ->mapToSelect();
    }
}
