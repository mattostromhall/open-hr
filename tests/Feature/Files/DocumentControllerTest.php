<?php

use Domain\Auth\Enums\Role;
use Domain\Files\Enums\DocumentableType;
use Domain\Files\Models\Document;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the documents index', function () {
    $this->get(route('document.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Files/Documents/Index')
                ->where('path', '/documents/')
                ->where('backPath', null)
                ->hasAll([
                    'topLevelDirectories',
                    'directories',
                    'files',
                    'documentList'
                ])
        );
});

it('returns the documents index for the path', function () {
    $this->get(route('document.index.path', ['path' => 'organisation']))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Files/Documents/Index')
                ->where('path', '/documents/organisation')
                ->where('backPath', null)
                ->hasAll([
                    'topLevelDirectories',
                    'directories',
                    'files',
                    'documentList'
                ])
        );
});

it('uploads the documents provided', function () {
    $this->person->assign(Role::PERSON);

    $response = $this->post(route('document.store'), [
        'path' => 'test',
        'documents' => [UploadedFile::fake()->create('document.pdf', 10)],
        'documentable_id' => $this->person->id,
        'documentable_type' => DocumentableType::PERSON->value
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Documents successfully uploaded!');
});

it('returns unauthorized if the person does not have permission to upload documents', function () {
    $response = $this->post(route('document.store'), [
        'path' => 'test',
        'documents' => [UploadedFile::fake()->create('document.pdf', 10)],
        'documentable_id' => $this->person->id,
        'documentable_type' => DocumentableType::PERSON->value
    ]);

    $response->assertForbidden();
});

it('returns validation errors when uploading documents with incorrect data', function () {
    $response = $this->post(route('document.store'), [
        'documents' => null,
        'documentable_id' => null,
        'documentable_type' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['documents', 'documentable_id', 'documentable_type']);
});

it('deletes the document', function () {
    $this->person->assign(Role::PERSON);

    $document = Document::factory()->create([
        'documentable_id' => $this->person->id
    ]);
    $response = $this->delete(route('document.destroy', ['document' => $document]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Document deleted!');
});

it('returns unauthorized if the person does not have permission to delete the document', function () {
    $document = Document::factory()->create([
        'documentable_id' => $this->person->id
    ]);
    $response = $this->delete(route('document.destroy', ['document' => $document]));

    $response->assertForbidden();
});
