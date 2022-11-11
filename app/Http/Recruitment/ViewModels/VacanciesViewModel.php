<?php

namespace App\Http\Recruitment\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\People\Models\Person;
use Domain\Recruitment\Enums\ContractType;
use Domain\Recruitment\Models\Vacancy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class VacanciesViewModel extends ViewModel
{
    public function active(): string
    {
        return request()->query('active', 'post');
    }

    public function contacts(): SupportCollection
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

    public function open(): Collection
    {
        return Vacancy::query()
            ->select('id', 'title', 'location', 'contract_type', 'open_at', 'close_at')
            ->whereOpen()
            ->get();
    }

    public function closed(): Collection
    {
        return Vacancy::query()
            ->select('id', 'title', 'location', 'contract_type', 'open_at', 'close_at')
            ->whereClosed()
            ->get();
    }
}
