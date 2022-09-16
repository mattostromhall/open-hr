<?php

namespace App\Http\Dashboard\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;
use Illuminate\Support\Str;

class OrganisationDashboardViewModel extends ViewModel
{
    public function organisation()
    {
        return organisation();
    }

    public function logo(): string
    {
        return Str::after($this->organisation()->logo, 'public');
    }

    public function headCount(): int
    {
        return Person::query()
            ->current()
            ->count();
    }

    public function departmentCount(): int
    {
        return Department::query()->count();
    }
}
