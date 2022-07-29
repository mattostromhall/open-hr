<?php

namespace App\Http\Files\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Files\Enums\DocumentableType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentsViewModel extends ViewModel
{
    public function __construct(protected ?string $path)
    {
        //
    }

    public function path(): string
    {
        return '/documents/' . $this->path;
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
        if (! $this->path) {
            return $this->topLevelDirectories();
        }

        return collect(Storage::directories($this->path))
            ->map(fn (string $directory) => [
                'path' => '/documents/' . $directory,
                'name' => Str::after($directory, $this->path . '/')
            ])
            ->toArray();
    }

    public function files(): array
    {
        if (! $this->path) {
            return [];
        }

        return collect(Storage::files($this->path))
            ->map(fn (string $file) => [
                'path' => '/documents/download/' . $file,
                'name' => Str::after($file, $this->path . '/')
            ])
            ->toArray();
    }
}
