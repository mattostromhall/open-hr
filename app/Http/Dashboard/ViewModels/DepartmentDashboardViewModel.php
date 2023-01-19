<?php

namespace App\Http\Dashboard\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Organisation\Models\Department;
use Illuminate\Support\Collection;

class DepartmentDashboardViewModel extends ViewModel
{
    public function __construct(protected ?Department $department = null)
    {
        //
    }

    public function department(): ?Department
    {
        return $this->department;
    }

    public function head(): ?string
    {
        return $this->department?->head->full_name;
    }

    public function memberCount(): ?int
    {
        return $this->department?->members()->count();
    }

    public function organisationNotifications(): Collection
    {
        return organisation()
            ->notifications()
            ->limit(10)
            ->get()
            ->map(fn ($notification) => $notification->body);
    }
}
