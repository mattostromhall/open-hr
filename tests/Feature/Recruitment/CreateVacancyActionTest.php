<?php

use Domain\People\Models\Person;
use Domain\Recruitment\Actions\CreateVacancyAction;
use Domain\Recruitment\DataTransferObjects\VacancyData;
use Domain\Recruitment\Enums\ContractType;
use Illuminate\Support\Str;
use function Pest\Faker\faker;
use Support\Enums\Currency;

it('creates a vacancy', function () {
    $person = Person::factory()->create();

    $action = app(CreateVacancyAction::class);
    $vacancyData = new VacancyData(
        contact: $person,
        public_id: Str::uuid(),
        title: 'Web Developer',
        description: faker()->randomHtml(),
        location: 'UK',
        contract_type: ContractType::FULL_TIME,
        remuneration: 70000,
        remuneration_currency: Currency::GBP,
        open_at: now()
    );

    $action->execute($vacancyData);

    $this->assertDatabaseHas('vacancies', [
        'contact_id' => $vacancyData->contact->id,
        'public_id' => $vacancyData->public_id,
        'title' => $vacancyData->title,
        'description' => $vacancyData->description,
        'location' => $vacancyData->location,
        'contract_type' => $vacancyData->contract_type,
        'remuneration' => $vacancyData->remuneration,
        'remuneration_currency' => $vacancyData->remuneration_currency,
        'open_at' => $vacancyData->open_at
    ]);
});
