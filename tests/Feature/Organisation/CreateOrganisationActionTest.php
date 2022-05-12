<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Domain\Organisation\Actions\CreateOrganisationAction;
use Domain\Organisation\DataTransferObjects\OrganisationData;

it('creates an organisation', function () {
    $action = app(CreateOrganisationAction::class);
    $file = UploadedFile::fake()->image('logo.png');
    $organisationData = new OrganisationData(name: 'ACME', logo: $file);

    $action->execute($organisationData);

    Storage::assertExists('public/images/logo.png');

    $this->assertDatabaseHas('organisation', [
        'name' => 'ACME',
        'logo' => 'public/images/logo.png',
        'setup_at' => now()
    ]);
});
