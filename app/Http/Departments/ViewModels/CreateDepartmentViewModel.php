<?php

namespace App\Http\Departments\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Collection;

class CreateDepartmentViewModel extends ViewModel
{
    public function people(): Collection
    {
        return Person::query()
            ->select('id', 'first_name', 'last_name')
            ->whereNotIn(
                'id',
                fn ($query) =>
                $query->select('head_of_department_id')->from('departments')
            )
            ->get();
    }
}
