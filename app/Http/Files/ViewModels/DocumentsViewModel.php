<?php

namespace App\Http\Files\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Files\DataTransferObjects\DocumentableData;
use Domain\Files\DataTransferObjects\DocumentListItemData;
use Domain\Files\Enums\DocumentableType;
use Domain\Files\Models\Document;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentsViewModel extends ViewModel
{
    public function __construct(
        protected string $path,
        protected DocumentableData $documentableData
    ) {
        //
    }

    public function path(): string
    {
        return $this->path;
    }

    public function backPath(): ?string
    {
        $back = Str::beforeLast($this->path, '/');

        if ($back === '/documents') {
            return null;
        }

        return $back;
    }

    public function documentable(): DocumentableData
    {
        return $this->documentableData;
    }

    public function topLevelDirectories(): array
    {
        return collect(DocumentableType::cases())
            ->map(fn (DocumentableType $type) => [
                'path' => '/documents/' . $type->plural(),
                'name' => $type->plural()
            ])
            ->toArray();
    }

    public function directories(): Collection
    {
        if ($this->path === '/documents/') {
            return collect([]);
        }

        return collect(Storage::directories($this->path))
            ->map(fn (string $directory) => new DocumentListItemData(
                path: '/' . $directory,
                name: Str::after('/' . $directory, $this->path . '/'),
                kind: 'folder'
            ));
    }

    public function files(): Collection
    {
        return Document::query()
            ->inDirectory($this->path)
            ->get()
            ->toList();
    }

    public function documentList(): Collection
    {
        return $this->directories()->concat($this->files());
    }
}
