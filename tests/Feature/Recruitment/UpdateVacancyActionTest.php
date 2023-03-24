<?php

use Domain\Recruitment\Actions\UpdateVacancyAction;
use Domain\Recruitment\DataTransferObjects\VacancyData;
use Domain\Recruitment\Enums\ContractType;
use Domain\Recruitment\Models\Vacancy;
use Support\Actions\StripScriptTagsAction;
use Support\Enums\Currency;
use function Pest\Faker\fake;

it('updates a vacancy', function () {
    $vacancy = Vacancy::factory()->create();

    $action = app(UpdateVacancyAction::class);
    $vacancyData = new VacancyData(
        contact: $vacancy->contact,
        public_id: $vacancy->public_id,
        title: $vacancy->title,
        description: fake()->randomHtml(),
        location: $vacancy->location,
        contract_type: ContractType::FIXED_TERM,
        contract_length: '1 year',
        remuneration: 70000,
        remuneration_currency: Currency::USD,
        open_at: $vacancy->open_at
    );

    $this->assertModelExists($vacancy);

    $action->execute($vacancy, $vacancyData);

    $this->assertDatabaseHas('vacancies', [
        'contact_id' => $vacancyData->contact->id,
        'public_id' => $vacancyData->public_id,
        'title' => $vacancyData->title,
        'description' => app(StripScriptTagsAction::class)->execute($vacancyData->description),
        'location' => $vacancyData->location,
        'contract_type' => $vacancyData->contract_type,
        'remuneration' => $vacancyData->remuneration * 100,
        'remuneration_currency' => $vacancyData->remuneration_currency,
        'open_at' => $vacancyData->open_at
    ]);
});
