<?php

use Domain\Auth\Enums\Role;
use Domain\Files\Enums\DocumentableType;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('downloads the document for the path provided', function () {
    $this->person->user->assign(Role::PERSON->value);

    $this->post(route('document.store'), [
        'path' => '/documents/test',
        'documents' => [UploadedFile::fake()->create('document.pdf', 10)],
        'documentable_id' => $this->person->id,
        'documentable_type' => DocumentableType::PERSON->value
    ]);

    $response = $this->get(
        route('document.download', ['path' => 'documents/test/document.pdf'])
    );

    $response->assertStatus(200);
});

it('returns unauthorized if the person does not have permission to download the document', function () {
    $this->person->user->assign(Role::PERSON->value);

    $this->post(route('document.store'), [
        'path' => '/documents/test',
        'documents' => [UploadedFile::fake()->create('document.pdf', 10)],
        'documentable_id' => $this->person->id,
        'documentable_type' => DocumentableType::PERSON->value
    ]);

    $person = Person::factory()->create();
    $this->actingAs($person->user);

    $response = $this->get(
        route('document.download', ['path' => 'documents/test/document.pdf'])
    );

    $response->assertForbidden();
});

it('returns a 404 if the document does not exist', function () {
    $response = $this->get(
        route('document.download', ['path' => '123456789'])
    );

    $response->assertStatus(404);
});
