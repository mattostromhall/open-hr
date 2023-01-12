<?php

namespace Domain\Files\Actions;

use Domain\Files\Actions\Contracts\DocumentableDataFromDocumentPathActionInterface;
use Domain\Files\DataTransferObjects\DocumentableData;
use Domain\Files\Enums\DocumentableType;
use Domain\People\Models\Person;
use Illuminate\Support\Str;

class DocumentableDataFromDocumentPathAction implements DocumentableDataFromDocumentPathActionInterface
{
    public function execute(string $path): DocumentableData
    {
        $type = Str::of($path)
            ->after('/documents/')
            ->before('/')
            ->toString();

        $id = Str::of($path)
            ->after('/documents/' . $type . '/')
            ->before('/')
            ->toString();

        if (! $type || ! $id) {
            return new DocumentableData(
                id: 1,
                type: DocumentableType::ORGANISATION
            );
        }

        if (DocumentableType::fromPlural($type) === DocumentableType::PERSON) {
            $names = explode(' ', $id);
            $person = Person::query()
                ->select('id')
                ->where('first_name', $names[0])
                ->where('last_name', $names[1])
                ->first();

            return new DocumentableData(
                id: $person->id,
                type: DocumentableType::PERSON
            );
        }

        return new DocumentableData(
            id: (int) $id,
            type: DocumentableType::fromPlural($type)
        );
    }
}
