<?php

namespace App\Http\People\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Auth\Models\User;
use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Collection;

class PersonViewModel extends ViewModel
{
    protected User $user;

    public function __construct(protected Person $person)
    {
        $this->user = $person->user;
    }

    public function user()
    {
        return $this->user;
    }

    public function person(): Person
    {
        return $this->person;
    }

    public function people(): Collection
    {
        return Person::query()
            ->select('id', 'first_name', 'last_name')
            ->whereNot('id', $this->person->id)
            ->get();
    }

    public function departments(): Collection
    {
        return Department::all();
    }

    public function address()
    {
        return $this->person->address;
    }

    public function directReports()
    {
        return $this->person->directReports->pluck('id');
    }

    public function roles()
    {
        $this->user->assignedRoles();
    }

    public function abilities()
    {
        $this->user->assignedAbilities();
    }
}
