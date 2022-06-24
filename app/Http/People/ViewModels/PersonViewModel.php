<?php

namespace App\Http\People\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Auth\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PersonViewModel extends ViewModel
{
    public function people(): Collection
    {
        return User::query()
            ->select('id', 'email')
            ->with([
                'person:id,user_id,department_id,first_name,last_name,pronouns,position' => [
                    'department:id,name'
                ],
            ])
            ->get();
    }
}
