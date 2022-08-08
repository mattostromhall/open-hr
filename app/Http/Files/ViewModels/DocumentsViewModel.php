<?php

namespace App\Http\Files\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Files\DataTransferObjects\DocumentListItemData;
use Domain\Files\Enums\DocumentableType;
use Domain\Files\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentsViewModel extends ViewModel
{
    public function __construct(protected string $path)
    {
        //
    }

    public function path(): string
    {
        return '/documents' . $this->path;
    }

    public function topLevelDirectories(): array
    {
        return collect(DocumentableType::cases())
            ->map(fn (DocumentableType $type) => [
                'path' => '/documents/' . $type->value,
                'name' => $type->value
            ])
            ->toArray();
    }

    public function directories(): array
    {
        if ($this->path === '/') {
            return [];
        }

        return collect(Storage::directories($this->path))
            ->map(fn (string $directory) => new DocumentListItemData(
                path: '/documents/' . $directory,
                name: Str::after('/' . $directory, $this->path . '/'),
                kind: 'folder'
            ))
            ->toArray();
    }

    public function files(): array
    {
        return Document::query()
            ->inDirectory($this->path)
            ->get()
            ->toList()
            ->toArray();
    }
}
