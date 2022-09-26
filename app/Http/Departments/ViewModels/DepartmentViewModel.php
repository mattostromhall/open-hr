<?php

namespace App\Http\Departments\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;
use Illuminate\Support\Collection;

class DepartmentViewModel extends ViewModel
{
    public function __construct(protected Department $department)
    {
        //
    }

    public function department(): Department
    {
        return $this->department;
    }

    public function head()
    {
        return $this->department
            ->head
            ->only('id', 'first_name', 'last_name', 'full_name');
    }

    public function members(): Collection
    {
        return $this->department
            ->members
            ->map(fn (Person $member) => $member->only('id', 'first_name', 'last_name', 'full_name'));
    }
}
