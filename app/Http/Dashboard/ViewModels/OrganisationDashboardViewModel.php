<?php

namespace App\Http\Dashboard\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class OrganisationDashboardViewModel extends ViewModel
{

    public function __construct(protected Organisation $organisation)
    {
        //
    }

    public function organisation(): Organisation
    {
        return $this->organisation;
    }

    public function logo(): string
    {
        return Str::after($this->organisation->logo, 'public');
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

    public function organisationNotifications(): Collection
    {
        return $this->organisation
            ->notifications()
            ->limit(10)
            ->get()
            ->map(fn ($notification) => $notification->body);
    }
}
