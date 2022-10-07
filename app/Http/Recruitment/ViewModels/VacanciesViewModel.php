<?php

namespace App\Http\Recruitment\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\People\Models\Person;
use Domain\Recruitment\Enums\ContractType;
use Illuminate\Support\Collection;

class VacanciesViewModel extends ViewModel
{
    public function active(): string
    {
        return 'post';
    }

    public function contacts(): Collection
    {
        return Person::query()
            ->select('id', 'first_name', 'last_name')
            ->get()
            ->map(fn (Person $person) => [
                'value' => $person->id,
                'display' => $person->full_name
            ]);
    }

    public function contractTypes(): array
    {
        return ContractType::cases();
    }
}
