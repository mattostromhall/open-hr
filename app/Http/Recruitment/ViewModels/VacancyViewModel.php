<?php

namespace App\Http\Recruitment\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\People\Models\Person;
use Domain\Recruitment\Enums\ContractType;
use Domain\Recruitment\Models\Vacancy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class VacancyViewModel extends ViewModel
{
    public function __construct(protected Vacancy $vacancy)
    {
        //
    }

    public function active(): string
    {
        return request()->query('active', 'overview');
    }

    public function vacancy(): array
    {
        return $this->vacancy->only(
            'id',
            'contact_id',
            'public_id',
            'title',
            'description',
            'location',
            'contract_type',
            'contract_length',
            'remuneration',
            'remuneration_currency',
            'open_at',
            'close_at'
        );
    }

    public function contact()
    {
        return $this->vacancy->contact->only('id', 'full_name');
    }

    public function applications(): LengthAwarePaginator
    {
        return $this->vacancy
            ->applications()
            ->select('id', 'vacancy_id', 'name', 'status', 'contact_number', 'contact_email')
            ->paginate()
            ->withQueryString();
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
