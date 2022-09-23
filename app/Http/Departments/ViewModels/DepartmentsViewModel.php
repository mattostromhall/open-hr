<?php

namespace App\Http\Departments\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Organisation\Models\Department;
use Illuminate\Database\Eloquent\Collection;

class DepartmentsViewModel extends ViewModel
{
    public function departments(): Collection
    {
        return Department::query()
            ->select('id', 'head_of_department_id', 'name')
            ->includeSize()
            ->includeHead()
            ->get();
    }
}
