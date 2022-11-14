<?php

namespace App\Http\Departments\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Organisation\Models\Department;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class DepartmentsViewModel extends ViewModel
{
    public function search(): ?string
    {
        return request()->query('search');
    }

    public function departments(): LengthAwarePaginator
    {
        return Department::query()
            ->select('id', 'head_of_department_id', 'name')
            ->includeSize()
            ->includeHead()
            ->filter(request()->query('search'))
            ->paginate()
            ->withQueryString();
    }
}
